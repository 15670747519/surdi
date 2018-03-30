<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$periods = M('Period')->order('till ASC')->select();
    	$this->assign('periods', $periods);
        $this->display('index');
    }

    public function detail(){
    	$pid = I('request.id');
    	$period = M('Period')->where(array('id'=>$pid))->find();
    	// 判断试题是否存在
    	if(!$pid || !$period['id']){
    		$this->error('请选择正确的调查问卷', U('/Home/Index/index'));
    	}
    	// 过期判断
    	if($period['till'] < NOW_TIME){
    		$this->error('本期问卷已经结束啦，敬请等待下期。', U('/Home/Index/index'));
    	}
    	// 还未开始判断
    	if($period['start'] > NOW_TIME){
			$this->error('本期问卷还没有开始哦，请耐心等待。', U('/Home/Index/index'));
    	}
    	// 获取分类
    	$types = M('Type')->where(array('pid'=>$pid))->order('`order` ASC')->select();
    	// 获取题目
    	$questions = M('Question')->where(array('pid'=>$pid, 'status'=>'1'))->order('`order` ASC')->select();
    	// 归类主键变更
    	$orderQuestions = $orderOptions = array();
    	$questionIds = array();
    	foreach ($questions as $key => $value) {
    		$orderQuestions[$value['tid']][$value['id']] = $value;
    		$orderOptions[$value['id']] = false;
    		$orderQuestions[$value['tid']][$value['id']]['options'] = &$orderOptions[$value['id']];
    		$questionIds[] = $value['id'];
    	}
    	// 获取题目选项
    	$options = M('Option')->where(array('qid'=>array('in', $questionIds)))->order('`order` ASC')->select();
    	foreach ($options as $key => $value) {
    		$orderOptions[$value['qid']][] = $value;
    	}

        // 获取基础问题
        $baseQuestions = M('BaseQuestion')->where(array('status'=>'1'))->order('`order` ASC')->select();
        foreach ($baseQuestions as $key => $value) {
            $orderBaseQuestions[$value['id']] = $value;
            $baseQuestionIds[] = $value['id'];
        }
        // 获取基础问题选项
        $options = M('BaseOption')->where(array('qid'=>array('in', $baseQuestionIds)))->order('`order` ASC')->select();
        foreach ($options as $key => $value) {
             $orderBaseQuestions[$value['qid']]['options'][] = $value;
        }

        $this->assign('period', $period);
        $this->assign('types', $types);
        $this->assign('questions', $orderQuestions);
        $this->assign('baseQuestions', $orderBaseQuestions);
        $this->display('detail');
    }

    public function post(){
    	$info = I('post.');
    	$pid = $info['id'];
    	$period = M('Period')->where(array('id'=>$pid))->find();
    	// 判断试题是否存在
    	if(!$pid || !$period['id']){
    		$this->error('请选择正确的调查问卷', U('/Home/Index/index'));
    	}
    	// 过期判断
    	if($period['till'] < NOW_TIME){
    		$this->error('本期问卷已经结束啦，敬请等待下期。', U('/Home/Index/index'));
    	}
    	// 还未开始判断
    	if($period['start'] > NOW_TIME){
			$this->error('本期问卷还没有开始哦，请耐心等待。', U('/Home/Index/index'));
    	}
    	if(!$info['tel'] && !$info['operator']){
			$this->error('请填写手机和运营商信息！');
		}
    	// 开启事务
    	M()->startTrans();
    	$user = array(
			'tel'		=>	$info['tel'],
			'operator'	=>	$info['operator']
		);
		// 用户手机入库
		$uid = M('User')->where(array('tel'=>$info['tel']))->getField('id');
		if($uid){
			if(M('Log')->where(array('uid'=>$uid))->getField('id')){
				$this->error('您已经参与过啦，请不要重复提交哦！');
			}
		}else{
			M('User')->create($user);
			$uid = M('User')->add();
		}
		if(!$uid){
			M()->rollback();
			$this->error('网速不给力，请再次提交试试！');
		}

		// 记录答题日志
		$log = array(
				'uid'	=> $uid,
				'pid'	=> $pid,
				'time'	=> NOW_TIME,
				'ip'	=> get_client_ip()
			);
		if(!M('Log')->add($log)){
			M()->rollback();
			$this->error('网速不给力，请再次提交试试！');
		}
		// 记录用户答案
    	foreach ($options as $key => $value) {
    		$orderOptions[$value['id']] = $value['addition'];
    	}
		foreach ($info['answer'] as $key => $value) {
			if(!$value){
				continue;
			}
			// TODO 填空题
			if(is_array($value)){
				foreach ($value as $v) {
					$answer = array(
						'qid'	=> $key,
						'oid' 	=> $v,
						'uid'	=> $uid
					);
					if($info['addition'][$v]){
						$answer['text'] = $info['addition'][$v];
					}
					if(!M('Answer')->add($answer)){
						M()->rollback();
						$this->error('网速不给力，请再次提交试试！');
					}
				}
			}else{
				$answer = array(
					'qid'	=> $key,
					'oid' 	=> $value,
					'uid'	=> $uid
				);
				if($info['addition'][$v]){
					$answer['text'] = $info['addition'][$v];
				}
				if(!M('Answer')->add($answer)){
					M()->rollback();
					$this->error('网速不给力，请再次提交试试！');
				}
			}
		}
		// 记录用户基本信息
    	foreach ($options as $key => $value) {
    		$orderOptions[$value['id']] = $value['addition'];
    	}
		foreach ($info['baseAnswer'] as $key => $value) {
			if(!$value){
				continue;
			}
			// TODO 填空题
			if(is_array($value)){
				foreach ($value as $v) {
					$answer = array(
						'qid'	=> $key,
						'pid'	=> $pid,
						'oid' 	=> $v,
						'uid'	=> $uid
					);
					if($info['baseAddition'][$v]){
						$answer['text'] = $info['baseAddition'][$v];
					}
					if(!M('BaseAnswer')->add($answer)){
						M()->rollback();
						$this->error('网速不给力，请再次提交试试！');
					}
				}
			}else{
				$answer = array(
					'qid'	=> $key,
					'pid'	=> $pid,
					'oid' 	=> $value,
					'uid'	=> $uid
				);
				if($info['baseAddition'][$v]){
					$answer['text'] = $info['baseAddition'][$v];
				}
				if(!M('BaseAnswer')->add($answer)){
					M()->rollback();
					$this->error('网速不给力，请再次提交试试！');
				}
			}
		}
		M()->commit();
		$this->success('提交成功！', U('Index'));
    }
}