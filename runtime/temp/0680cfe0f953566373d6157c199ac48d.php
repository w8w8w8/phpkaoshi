<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:66:"D:\phpstudy_pro\WWW\addons\kaoshi\view\user_plan\studyhistory.html";i:1582767522;s:58:"D:\phpstudy_pro\WWW\addons\kaoshi\view\layout\default.html";i:1582767522;s:55:"D:\phpstudy_pro\WWW\addons\kaoshi\view\common\meta.html";i:1582767522;s:57:"D:\phpstudy_pro\WWW\addons\kaoshi\view\common\script.html";i:1582767522;}*/ ?>
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
</div>
<div class="cmain nopad-lr">
	<?php if(count($history) == 0): ?>
	<div style="text-align: center">暂无学习答题记录！</div>

	<?php else: ?>
	<ul class="study_list">
		<?php if(is_array($history) || $history instanceof \think\Collection || $history instanceof \think\Paginator): if( count($history)==0 ) : echo "" ;else: foreach($history as $key=>$vo): ?>
			<li>
			<div >
				<i class='study_statu <?php if($vo['status'] == 0): ?> half <?php else: ?> over <?php endif; ?>'></i>
				<div class="last_study">
					<em><?php echo date('Y-m-d H:i',$vo['lasttime']); ?></em>
				</div>
				<div class="study_content">
					<h4 class="study_name"><?php echo $vo['plan_name']; ?></h4>
					<div class="study_process">
						<span class="answernum">已答 <em><?php echo $vo['finished']; ?></em>/<?php echo $vo['number']; ?></span>
						<?php if($vo['status'] == 1): ?>
						<span class="study_num">分数:<em><?php echo intval($vo['score']); ?></em></span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</li>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
	<?php endif; ?>
</div>
</body>



</html>