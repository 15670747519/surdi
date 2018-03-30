<?php
if(!defined('APP_PATH')||!defined('DOYO_PATH')){exit('Access Denied');}
class ajax extends syController
{
	function __construct(){
		parent::__construct();
		$this->sy_class_type=syClass('syclasstype');
		$this->db=$GLOBALS['G_DY']['db']['prefix'];
	}
	function vercode(){
		if(md5(strtolower($this->syArgs("vercode",1)))!=$_SESSION['doyo_verify']){echo 'false';}else{echo 'true';}
	}
	function mycart(){
		$my=syClass('symember')->islogin(0);
		if($my['id']!=0){
			$g=syDB('goodscart')->findAll(array('uid'=>$my['id']),'aid desc,id desc');
			$gs=array();$i=0;
			foreach($g as $v){
				$va=syDB('product')->find(array('id'=>$v['aid'],'isshow'=>1),null,'title,price,litpic');
				$gs[$i]= array(
					'cartid' => $v['id'],
					'aid' => $v['aid'],
					'quantity' => $v['num'],
					'title' => $va['title'],
					'img' => $va['litpic'],
					'price' => $va['price'],
				);
				$attribute=unserialize($v['attribute']);
				if($attribute){			
					$p_type=syDB('attribute_type')->findSql('select distinct a.tid,a.aid,b.tid,b.isshow,b.orders,b.name from '.$this->db.'product_attribute a left join '.$this->db.'attribute_type b on (a.tid=b.tid) where a.aid='.$gs[$i]['aid'].' and b.isshow=1 order by b.orders desc,b.tid desc');
					foreach($p_type as $vp){
						$p=syDB('product_attribute')->find(array('aid' => $gs[$i]['aid'],'tid' => $vp['tid'],'sid' => $attribute[$vp['tid']]),null,'price');
						$gs[$i]['price']=$gs[$i]['price']+$p['price'];
						$a=syDB('attribute')->find(array('sid' => $attribute[$vp['tid']]),null,'name');
						$gs[$i]['attribute_txt'].=$vp['name'].'('.$a['name'].') ';
					}
				}
				$i++;
			}
		}
		$this->cart=$gs;
		$this->display($this->syArgs('template',1));
	}
	function mycart_total(){
		$my=syClass('symember')->islogin(0);
		if($my['id']!=0){
			echo total_page($this->db.'goodscart where uid='.$my['id']);
		}
	}
	function fields_contingency(){
		$molds=$this->syArgs('molds',1);
		$word=$this->syArgs('word',1);
		$fields=$this->syArgs('fields',1);
		if($word&&$molds&&$fields){
			$w.=" where ";
			$str = explode(' ',$word);
			foreach($str as $s){
				if($s)$w.=" title like '%".$s."%' or";
			}
			$w=rtrim($w,'or')." ";
			$sql='select id,title,addtime,orders from '.$this->db.$molds.$w.' order by orders desc,addtime desc,id desc limit 0,10';
			$info=syDB($molds)->findSql($sql); 
			if($info){
				foreach($info as $v){
					echo '<li onMouseOver=contingency_id_'.$fields.'('.$v['id'].',"'.$v['title'].'");>·'.$v['title'].'</li>';
				}
			}else{
				echo '<li>没有找到任何内容</li>';
			}
		}
	}
	function member_login(){
		$this->member=syClass('symember')->islogin(0);
		$this->display($this->syArgs('template',1));
	}
	function member_app(){
		$member=syClass('symember')->islogin(0);
		if($member['id']>0){
			$items = syDB('member_field')->find(array('aid'=>$member['id']),null,"app,appapp");
			if($items['app']&&count(unserialize($items['app']))>0){
				$sql='select * from '.$this->db.'app a left join '.$this->db.'app_field b on (a.id=b.aid) where a.id in ('. implode(',',unserialize($items['app'])).') order by orders desc,addtime desc,id desc';
			}else{
				$sql='select * from '.$this->db.'app a left join '.$this->db.'app_field b on (a.id=b.aid) where tid = 43 order by orders desc,addtime desc,id desc';
			}
			$this->app = syDB('app')->findSql($sql);
			if($items['appapp']&&count(unserialize($items['appapp']))>0){
				$sql='select * from '.$this->db.'app a left join '.$this->db.'app_field b on (a.id=b.aid) where a.id in ('. implode(',',unserialize($items['appapp'])).') order by orders desc,addtime desc,id desc';
			}else{
				$sql='select * from '.$this->db.'app a left join '.$this->db.'app_field b on (a.id=b.aid) where tid = 44 order by orders desc,addtime desc,id desc';
			}
			$this->appapp = syDB('app')->findSql($sql);
		}else{
			$this->nologin = true;
		}
		$this->display('member/app.html');
	}

	function member_hide_app(){
		$member=syClass('symember')->islogin(0);
		if($member['id']>0){
			$items = syDB('member_field')->find(array('aid'=>$member['id']),null,"app,appapp");
			if($this->syArgs('type',1)=='app'){
				if($items['app']&&count(unserialize($items['app']))>0){
					$sql='select * from '.$this->db.'app a left join '.$this->db.'app_field b on (a.id=b.aid) where a.id not in ('. implode(',',unserialize($items['app'])).') and tid=43 order by orders desc,addtime desc,id desc';
					$this->app = syDB('app')->findSql($sql);
				}
				
			}else{
				if($items['appapp']&&count(unserialize($items['appapp']))>0){
					$sql='select * from '.$this->db.'app a left join '.$this->db.'app_field b on (a.id=b.aid) where a.id not in ('. implode(',',unserialize($items['appapp'])).') and tid=44 order by orders desc,addtime desc,id desc';
					$this->app = syDB('app')->findSql($sql);
				}
			}
		}
		$this->type = $this->syArgs('type',1);
		$this->display('member/app_hide.html');
	}

	function member_add_app(){
		$member=syClass('symember')->islogin(0);
		if($member['id']>0){
			$items = syDB('member_field')->find(array('aid'=>$member['id']),null,"app,appapp");
			$arr = unserialize($items[$this->syArgs('type',1)]);
			array_push($arr, $this->syArgs('id',1));
			syDB('member_field')->update(array('aid'=>$member['id']),array($this->syArgs('type',1)=>serialize($arr)));
			$sql='select * from '.$this->db.'app a left join '.$this->db.'app_field b on (a.id=b.aid) where a.id='.$this->syArgs('id',1).' order by orders desc,addtime desc,id desc';
			$this->app = syDB('app')->findSql($sql);
			$this->type = $this->syArgs('type',1);
			$this->display('member/app_show.html');
		}
	}

	function member_del_app(){
		$member=syClass('symember')->islogin(0);
		if($member['id']>0){
			$items = syDB('member_field')->find(array('aid'=>$member['id']),null,"app,appapp");
			$arr = unserialize($items[$this->syArgs('type',1)]);
			if(!$arr){
				if($this->syArgs('type',1)=='app'){
					$w = " where tid=43";
				}else{
					$w = " where tid=44";
				}
				$sql='select id from '.$this->db.'app'.$w;
				$arr= getSubByKey(syDB('app')->findSql($sql),'id');
			}
			$arr = array_diff($arr,array(0=>$this->syArgs('id',1)));
			syDB('member_field')->update(array('aid'=>$member['id']),array($this->syArgs('type',1)=>serialize($arr)));
			$sql='select * from '.$this->db.'app a left join '.$this->db.'app_field b on (a.id=b.aid) where a.id='.$this->syArgs('id',1).' order by orders desc,addtime desc,id desc';
			$this->app = syDB('app')->findSql($sql);
			$this->type = $this->syArgs('type',1);
			$this->display('member/app_hide.html');
		}
	}

	function comment(){
		if(funsinfo('comment','isshow')==1){
			$c=syClass('c_comment');
			$total_page=total_page($GLOBALS['G_DY']['db']['prefix'].'comment where isshow=1 and aid='.$this->syArgs('aid').' and molds="'.$this->syArgs('molds',1).'"');
			$this->comment=$c->syPager($this->syArgs('comment_page',0,1),10,$total_page)->findAll(array('isshow'=>1,'aid'=>$this->syArgs('aid'),'molds'=>$this->syArgs('molds',1)),' addtime desc ');
			$c_page=$c->syPager()->getPager();
			$this->comment_page=pagetxt_ajax($c_page,$GLOBALS['G_DY']['url']["url_path_base"].'?c='.$this->syArgs('molds',1).'&id='.$this->syArgs('aid'),"ajax_comment('".$this->syArgs('id',1)."','".$this->syArgs('molds',1)."',".$this->syArgs('aid').",[_page_],'".$this->syArgs('template',1)."');");
			$this->display($this->syArgs('template',1));
		}
	}
	function record(){
		$c=syClass("c_sales_record");
		$total_page=total_page($GLOBALS['G_DY']['db']['prefix'].'sales_record where aid='.$this->syArgs('aid'));
		$this->record=$c->syPager($this->syArgs('record_page',0,1),10,$total_page)->findAll(array('aid'=>$this->syArgs('aid')),' stime desc ');
		$c_page=$c->syPager()->getPager();
		$this->record_page=pagetxt_ajax($c_page,$GLOBALS['G_DY']['url']["url_path_base"].'?c=product&id='.$this->syArgs('aid'),"ajax_record('".$this->syArgs('id',1)."',".$this->syArgs('aid').",[_page_],'".$this->syArgs('template',1)."');");
		$this->display($this->syArgs('template',1));
	}
}