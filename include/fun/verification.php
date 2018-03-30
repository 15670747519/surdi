<?php
function verification($type){
	switch ($type){
		case 1:
			return  '<p></p><a href="http://www.crystalcg.com" target="_blank">水晶石数字科技</a>';
		break;
		case 2:
			return ' | <a href="http://www.crystalcg.com" target="_blank">水晶石数字科技有限公司上海分公司</a>';
		break;
		case 3:
			return '';
		break;
		case 4:
			return '&nbsp;&nbsp;<a href="http://www.crystalcg.com" target="_blank">水晶石数字科技有限公司上海分公司</a> 版本'.syExt('version').' - '.syExt('update').' Powered by <a href="http://www.crystalcg.com/" target="_blank">crystalcg.com</a> © 2008-2013';
		break;
		case 5:
			return '';
		break;
		case 6:
		return 'href="http://www.crystalcg.com" target="_blank"';
		break;
		case 7:
		return '';
		break;
		case 8:
		return '水晶石数字科技';
		break;
	}
}
?>