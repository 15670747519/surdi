<?php
define("APP_PATH",dirname(__FILE__));
define("DOYO_PATH",APP_PATH."/include");
@date_default_timezone_set('PRC');
$doyoConfig = array(

'db' => array(
'host' => '127.0.0.1',			//数据库地址
'port' => 3306,					//数据库端口
'database' => 'pro_city',		//数据库名
'login' => 'pro_city',				//数据库帐号
'password' => 'Rt31135995@',			//数据库密码
'prefix' => 'supdri_',				//数据库表前缀
'driver' => 'mysqli'
),

'ext' => array(
'version' => '2.3',
'update' => '20130118',
'auto_update' => 1,
'http_path' => 'http://www.supdri.com',
'site_title' => '上海市城市规划设计研究院',
'site_keywords' => '上海市城市规划设计研究院',
'site_description' => '上海市城市规划设计研究院',
'secret_key' => '9fa2660f2d882897601603253bb37206',	//站内安全密钥，安装时会随机生成，一旦生成请勿修改，并请牢记，否则可能造成某些数据无法取回。
'view_themes' => 'city_rootant',
'site_html' => 0,
'site_html_dir' => 'html',
'site_html_rules' => '[mold]/[file].html',
'site_html_suffix' => '.html',
'site_html_index' => 0,
'enable_gzip' => 0,
'enable_gzip_level' => 6,
'cache_auto' => 0,
'cache_time' => 0,
'filetype' => 'jpg,gif,jpeg,bmp,png,swf,flv,wmv,wma,mp3,mp4,rar,zip,7z,txt,pdf,doc,docx,xls,xlsx',
'filesize' => 102400000,
'imgwater' => 0,
'imgwater_t' => 3,
'imgcaling' => 1,
'img_w' => 1000,
'img_h' => 1000,
'comment_audit' => 0,
'comment_user' => 0,
// 康盛UCenter的设置

'syUcenter' => array(
'UC_CLIENT_DIR' => "", // uc_client文件夹的目录，无需设置

'UC_CONNECT' => 'mysql', // 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen()
// mysql 是直接连接的数据库, 为了效率, 建议采用 mysql

//数据库相关 (mysql 连接时, 并且没有设置 UC_DBLINK 时, 需要配置以下变量)
'UC_DBHOST' => '127.0.0.1', // UCenter 数据库主机
'UC_DBUSER' => 'root', // UCenter 数据库用户名
'UC_DBPW' => '123456x', // UCenter 数据库密码
'UC_DBNAME' => 'pro_city', // UCenter 数据库名称
'UC_DBCHARSET' => 'utf8', // UCenter 数据库字符集
'UC_DBTABLEPRE' => '`pro_city`.uc_', // UCenter 数据库表前缀，务必注意：最好在表前缀前加上库名

//通信相关
'UC_KEY' => 'olJscKShxdwqUmsdlJxOsduNwq', // 与 UCenter 的通信密钥, 要与 UCenter 保持一致
'UC_API' => 'http://ucenter.supdri.com', // UCenter 的 URL 地址, 在调用头像时依赖此常量
'UC_CHARSET' => 'utf8', // UCenter 的字符集
'UC_IP' => '', // UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析
'UC_APPID' => 1, // 当前应用的 ID
'UC_PPP' => 20
),
),
);


define('UC_CONNECT', 'mysql');
define('UC_DBHOST', '42.121.5.73');
define('UC_DBUSER', 'pro_city');
define('UC_DBPW', '123456x');
define('UC_DBNAME', 'pro_city');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`pro_city`.uc_');
define('UC_DBCONNECT', '0');
define('UC_KEY', 'olJscKShxdwqUmsdlJxOsduNwq');
define('UC_API', 'http://ucenter.supdri.com');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '');
define('UC_APPID', '1');
define('UC_PPP', '20');
