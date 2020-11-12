<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"D:\phpstudy_pro\WWW\public/../application/admin\view\kaoshi\examination\plan\add.html";i:1604800548;s:62:"D:\phpstudy_pro\WWW\application\admin\view\layout\default.html";i:1602168705;s:59:"D:\phpstudy_pro\WWW\application\admin\view\common\meta.html";i:1602168705;s:61:"D:\phpstudy_pro\WWW\application\admin\view\common\script.html";i:1602168705;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Subject_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-subject_id" data-rule="required" data-field="subject_name" data-source="kaoshi/subject/index" class="form-control selectpage" name="row[subject_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Exam_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
             <input id="c-exam_id" data-rule="required" data-field="exam_name" data-source="kaoshi/examination/exams/index" class="form-control selectpage" name="row[exam_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('user_ids'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-user_ids" data-rule="required" data-field="username" data-source="user/user/index" class="form-control selectpage" name="row[user_ids]" type="text" value="" data-multiple="true" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Plan_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-plan_name" data-rule="required" class="form-control" name="row[plan_name]" type="text">
        </div>
    </div>

     <div class="form-group time0">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Times'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-times" data-rule="required" min='0' step="1"  class="form-control" name="row[times]" type="number" value="0" placeholder="0为不限次数">
        </div>
    </div>

    <div class="form-group time1 ">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Hours'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-hours" data-rule="required"  min='1' step="1"  class="form-control" name="row[hours]" type="number" value="60">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-type" data-rule="integer" class="form-control selectpicker" name="row[type]">
                <?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): if( count($typeList)==0 ) : echo "" ;else: foreach($typeList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"0"))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Starttime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-starttime" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[starttime]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Endtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-endtime" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[endtime]" type="text" value="<?php echo date('Y-m-d H:i:s',strtotime('+1 day')); ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
