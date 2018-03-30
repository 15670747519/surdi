<?php 
require("config.php");
require(DOYO_PATH."/sys.php");

$php_self = htmlspecialchars(getPhpSelf());
if($php_self === false)
	exit;

$site_path = substr($php_self, 0, strrpos($php_self, '/'));
$site_url = htmlspecialchars('http://'.$_SERVER['HTTP_HOST'].$site_path.'/');

// 获取文件地址
$file = htmlspecialchars($_REQUEST['img']);
$gen = (int)htmlspecialchars($_REQUEST['gen']);
$arr = explode('_',$file);
$path = $arr[0];
$arr = explode('.',$arr[1]);
$size = $arr[0];
$size = explode('x',$size);
$width = (int)$size[0];
$height = (int)$size[1];
$ext = $arr[1];

$path = APP_PATH . $path . '.' . $ext;
echo $path;
if(file_exists(APP_PATH.$file))
{
	@header("location: ".$site_url.$file,true);
	exit;
}

if(!file_exists($path))
	exit;

switch ($gen) {
	case 1:
		$type = IMAGE_THUMB_SCALE;
		break;
	case 2:
		$type = IMAGE_THUMB_FILLED;
		break;
	case 3:
		$type = IMAGE_THUMB_CENTER;
		break;
	case 4:
		$type = IMAGE_THUMB_NORTHWEST;
		break;
	case 5:
		$type = IMAGE_THUMB_SOUTHEAST;
		break;
	case 6:
		$type = IMAGE_THUMB_FIXED;
		break;
	default:
		$type = IMAGE_THUMB_SCALE;
		break;
}
$image = syClass('sycrop');
$image->open($path);
$image->thumb($width, $height, $type);
$image->save(APP_PATH . $file);
if($image === false)
    exit;

@header("location: ".$site_url.$file,true);
?>