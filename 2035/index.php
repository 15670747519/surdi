<?php
  $time = date('H');
 if($time >= 170 || $time < -7) {
?>
<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>上海2040</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="../assets/i/favicon.png">
  <link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="am-g">
    <h1>上海2035</h1>
    <p>A system maintenance is currently underway.<br/>网站维护中，请稍后访问</p>
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <h3>维护时间 2016.9.1－2016.9.9 每日17:00～7:00</h3>
    <br>
    <br>
    <hr>
    <p>Copyright © 2018 上海2035 版权所有</p>
  </div>
</div>
</body>
</html>

<?php
} else {
  require("config.php");
  $doyoConfig['view']['config']['template_dir'] = APP_PATH.'/template/'.$doyoConfig['ext']['view_themes'];
  require(DOYO_PATH."/sys.php");
  spRun();
}