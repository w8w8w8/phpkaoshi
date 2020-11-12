<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:55:"D:\phpstudy_pro\WWW\addons\kaoshi\view\index\index.html";i:1582767522;s:58:"D:\phpstudy_pro\WWW\addons\kaoshi\view\layout\default.html";i:1582767522;s:55:"D:\phpstudy_pro\WWW\addons\kaoshi\view\common\meta.html";i:1582767522;s:57:"D:\phpstudy_pro\WWW\addons\kaoshi\view\common\script.html";i:1582767522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:'考试系统学生端'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<?php if(isset($keywords)): ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php endif; if(isset($description)): ?>
<meta name="description" content="<?php echo $description; ?>">
<?php endif; ?>
<meta name="author" content="FastAdmin">

<link rel="shortcut icon" href="/assets/addons/kaoshi/img/favicon.ico" />


<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/addons/kaoshi/js/html5shiv.js"></script>
  <script src="/assets/addons/kaoshi/js/respond.min.js"></script>
<![endif]-->


<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<link href="/assets/addons/kaoshi/css/bootstrap.css" rel="stylesheet">

<link href="/assets/addons/kaoshi/css/sfks-weixin.css" rel="stylesheet">

</head>

<script type="text/javascript" src="/assets/addons/kaoshi/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/addons/kaoshi/js/main.js"></script>
<script type="text/javascript" src="/assets/addons/kaoshi/js/plugin_wx.js"></script>




<body class="exampindex">
<div class="cheader">
    <div class="headerleft">
        <span>欢迎您，<?php echo $username; ?></span>
    </div>
    <div class="headeright">
        <a href="<?php echo addon_url('kaoshi/user/index'); ?>"><span class="imgicon imgicon_person"></span>个人资料</a>
    </div>
</div>
<div class="cmain">
    
    <ul class="examtype_list">
        <li>
            <a href="<?php echo addon_url('kaoshi/user_plan/study'); ?>">
                <span class="imgicon examptype1"></span>
                <p>在线学习</p>
            </a>
        </li>
        <li>
            <a href="<?php echo addon_url('kaoshi/user_plan/exam'); ?>">
                <span class="imgicon examptype2"></span>
                <p>在线考试</p>
            </a>
        </li>
        <li>
            <a href="<?php echo addon_url('kaoshi/user_plan/studyhistory'); ?>">
                <span class="imgicon examptype3"></span>
                <p>我的学习</p>
            </a>
        </li>
        <li>
            <a href="<?php echo addon_url('kaoshi/user_plan/examhistory'); ?>">
                <span class="imgicon examptype4"></span>
                <p>考试记录</p>
            </a>
        </li>
        <li>
            <a href="<?php echo addon_url('kaoshi/exams/rank',array('type'=>1)); ?>">
                <span class="imgicon examptype6"></span>
                <p>学习排行榜</p>
            </a>
        </li>
        <li>
            <a href="<?php echo addon_url('kaoshi/exams/rank',array('type'=>0)); ?>">
                <span class="imgicon examptype5"></span>
                <p>考试排行榜</p>
            </a>
        </li>
    </ul>
</div>

</body>



</html>