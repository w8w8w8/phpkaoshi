<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:54:"D:\phpstudy_pro\WWW\addons\kaoshi\view\user\index.html";i:1582767522;s:58:"D:\phpstudy_pro\WWW\addons\kaoshi\view\layout\default.html";i:1582767522;s:55:"D:\phpstudy_pro\WWW\addons\kaoshi\view\common\meta.html";i:1582767522;s:57:"D:\phpstudy_pro\WWW\addons\kaoshi\view\common\script.html";i:1582767522;}*/ ?>
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


<body>
<div class="cheader">
    <div class="headerleft">
        <a href="<?php echo addon_url('kaoshi/index/index'); ?>"><span class="arrow-left"></span></a>
    </div>
    <h1><?php echo $title; ?></h1>
    <!--<div class="headeright">-->
    <!--<a href="javascript:;" data-subform="personForm">完成</a>-->
    <!--</div>-->
</div>
<div class="cmain nopad-lr">

    <div class="common_form">
        <form method="post" action="<?php echo addon_url('kaoshi/index/index'); ?>" id="personForm">
            <div class="form_group">
                <div class="form_control">
                    <em>姓名</em>
                    <div class="control">
                        <span class="control-detail"><?php echo $user['nickname']; ?></span>
                    </div>
                </div>
                <div class="form_control">
                    <em>性别</em>
                    <div class="control">
                        <span class="control-detail"><?php echo $user['gender']==0?"女":"男"; ?></span>
                    </div>
                </div>
                <div class="form_control">
                    <em>邮箱</em>
                    <div class="control">
                        <span class="control-detail"><?php echo $user['email']; ?></span>
                    </div>
                </div>
                <div class="form_control">
                    <em>电话</em>
                    <div class="control">
                        <span class="control-detail"><?php echo $user['mobile']; ?></span>
                    </div>
                </div>
            </div>
        </form>
        <div class="form_group">

            <div class="form_control">
                <em>余额</em>
                <div class="control">
                    <span class="control-detail"><?php echo $user['money']; ?></span>
                </div>
            </div>
            <div class="form_control">
                <em>积分</em>
                <div class="control">
                    <span class="control-detail"><?php echo $user['score']; ?></span>
                </div>
            </div>
            <div class="form_control">
                <em>登录时间</em>
                <div class="control">
                    <span class="control-detail">
                        <?php echo date("Y-m-d H:i:s",$user['logintime']); ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="form_group">
            <div class="form_single_control">
                <a href="<?php echo addon_url('kaoshi/user/changepwd'); ?>"><span class="icon_lock1"></span> 重置密码</a>
            </div>
        </div>
        <div class="form_btn">
            <a style="background-color: #D43232;" href="<?php echo url('index/user/logout'); ?>" class="commonbtn">退出</a>
        </div>
    </div>
</div>
</body>


</html>