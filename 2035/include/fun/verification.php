<?php
function verification($type){
	switch ($type){
		case 1:
			return  '<p></p><a href="http://webllo.com" target="_blank">源蚁信息科技</a>';
		break;
		case 2:
			return ' | <a href="http://webllo.com" target="_blank">上海源蚁信息科技有限公司</a>';
		break;
		case 3:
			return '';
		break;
		case 4:
			return '&nbsp;&nbsp;<a href="http://webllo.com" target="_blank">上海源蚁信息科技有限公司</a> 版本'.syExt('version').' - '.syExt('update').' Powered by <a href="http://webllo.com" target="_blank">webllo.com</a> © 2012-2013';
		break;
		case 5:
			return '';
		break;
		case 6:
		return 'href="http://webllo.com" class="v" target="_blank"';
		break;
		case 7:
		return ' log';
		break;
		case 8:
		return '源蚁信息科技';
		break;
	}
}
?>