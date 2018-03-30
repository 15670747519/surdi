<?php
if(!defined('APP_PATH')||!defined('DOYO_PATH')){exit('Access Denied');}
class error extends syController
{
	function __construct(){
		parent::__construct();
		$this->molds = 'article';
		$this->moldname=moldsinfo('article','moldname');
		$this->sy_class_type=syClass('syclasstype');
		$this->Class=syClass('c_article');
		$this->db=$GLOBALS['G_DY']['db']['prefix'].'article';
	}
	function index(){
		$this->display('404.html');
	}
}
	