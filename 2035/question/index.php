<?php
// +----------------------------------------------------------------------
// | Rootant [ E questionnaire ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://rootant.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Evyn Mao <gfel@163.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', True);

// 定义应用目录
define('APP_PATH', './Application/');
// 引入ThinkPHP入口文件
require './Core/Core.php';