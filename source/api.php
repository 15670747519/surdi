<?php
if(!defined('APP_PATH')||!defined('DOYO_PATH')){exit('Access Denied');}
class api extends syController
{
	function __construct(){
		parent::__construct();
		$this->molds = 'article';
		$this->moldname=moldsinfo('article','moldname');
		$this->sy_class_type=syClass('syclasstype');
		$this->Class=syClass('c_article');
		$this->db=$GLOBALS['G_DY']['db']['prefix'].'article';
	}

	function flash(){
		$list[0] = $this->ads('5');
		$list[1] = $this->ads('6');
		$list[2] = $this->ads('7');
		$list[3] = $this->ads('8');
		echo json_encode($list);
		

	}

	private function ads($tid){
		$list = syDB('ads')->findAll(" taid=".$tid." ", "id DESC", "name,adfile,gourl");
		return $list[0];
	}

	function article(){
		$id = $this->syArgs('id');
		$article=syDB('article')->findSql('select id,tid,title,addtime,hits,user,body  from '.$this->db.' a left join '.$this->db.'_field b on (a.id=b.aid) where id='.$id.' and isshow=1 limit 1');
		echo json_encode($article);
	}
}