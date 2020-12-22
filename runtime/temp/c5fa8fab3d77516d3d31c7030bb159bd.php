<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:92:"D:\phpstudy_pro\WWW\public/../application/admin\view\kaoshi\examination\questions\index.html";i:1608536925;s:62:"D:\phpstudy_pro\WWW\application\admin\view\layout\default.html";i:1602168705;s:59:"D:\phpstudy_pro\WWW\application\admin\view\common\meta.html";i:1602168705;s:61:"D:\phpstudy_pro\WWW\application\admin\view\common\script.html";i:1602168705;}*/ ?>
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
                                <style>
    /*-------------------------------------
zTree Style

version:	3.4
author:		Hunter.z
email:		hunter.z@263.net
website:	http://code.google.com/p/jquerytree/

-------------------------------------*/

.ztree * {padding:0; margin:0; font-size:12px; font-family: Verdana, Arial, Helvetica, AppleGothic, sans-serif}
.ztree {margin:0; padding:5px; color:#333}
.ztree li{padding:0; margin:0; list-style:none; line-height:14px; text-align:left; white-space:nowrap; outline:0}
.ztree li ul{ margin:0; padding:0 0 0 18px}
.ztree li ul.line{ background:url(/assets/js/ztree/img/line_conn.gif) 0 0 repeat-y;}

.ztree li a {padding:1px 3px 0 0; margin:0; cursor:pointer; height:17px; color:#333; background-color: transparent;
	text-decoration:none; vertical-align:top; display: inline-block}
.ztree li a:hover {text-decoration:underline}
.ztree li a.curSelectedNode {padding-top:0px; background-color:#FFE6B0; color:black; height:16px; border:1px #FFB951 solid; opacity:0.8;}
.ztree li a.curSelectedNode_Edit {padding-top:0px; background-color:#FFE6B0; color:black; height:16px; border:1px #FFB951 solid; opacity:0.8;}
.ztree li a.tmpTargetNode_inner {padding-top:0px; background-color:#316AC5; color:white; height:16px; border:1px #316AC5 solid;
	opacity:0.8; filter:alpha(opacity=80)}
.ztree li a.tmpTargetNode_prev {}
.ztree li a.tmpTargetNode_next {}
.ztree li a input.rename {height:14px; width:80px; padding:0; margin:0;
	font-size:12px; border:1px #7EC4CC solid; *border:0px}
.ztree li span {line-height:16px; margin-right:2px}
.ztree li span.button {line-height:0; margin:0; width:16px; height:16px; display: inline-block; vertical-align:middle;
	border:0 none; cursor: pointer;outline:none;
	background-color:transparent; background-repeat:no-repeat; background-attachment: scroll;
	background-image:url("/assets/js/ztree/img/zTreeStandard.png"); *background-image:url("/assets/js/ztree/img/zTreeStandard.gif")}

.ztree li span.button.chk {width:13px; height:13px; margin:0 3px 0 0; cursor: auto}
.ztree li span.button.chk.checkbox_false_full {background-position:0 0}
.ztree li span.button.chk.checkbox_false_full_focus {background-position:0 -14px}
.ztree li span.button.chk.checkbox_false_part {background-position:0 -28px}
.ztree li span.button.chk.checkbox_false_part_focus {background-position:0 -42px}
.ztree li span.button.chk.checkbox_false_disable {background-position:0 -56px}
.ztree li span.button.chk.checkbox_true_full {background-position:-14px 0}
.ztree li span.button.chk.checkbox_true_full_focus {background-position:-14px -14px}
.ztree li span.button.chk.checkbox_true_part {background-position:-14px -28px}
.ztree li span.button.chk.checkbox_true_part_focus {background-position:-14px -42px}
.ztree li span.button.chk.checkbox_true_disable {background-position:-14px -56px}
.ztree li span.button.chk.radio_false_full {background-position:-28px 0}
.ztree li span.button.chk.radio_false_full_focus {background-position:-28px -14px}
.ztree li span.button.chk.radio_false_part {background-position:-28px -28px}
.ztree li span.button.chk.radio_false_part_focus {background-position:-28px -42px}
.ztree li span.button.chk.radio_false_disable {background-position:-28px -56px}
.ztree li span.button.chk.radio_true_full {background-position:-42px 0}
.ztree li span.button.chk.radio_true_full_focus {background-position:-42px -14px}
.ztree li span.button.chk.radio_true_part {background-position:-42px -28px}
.ztree li span.button.chk.radio_true_part_focus {background-position:-42px -42px}
.ztree li span.button.chk.radio_true_disable {background-position:-42px -56px}

.ztree li span.button.switch {width:18px; height:18px}
.ztree li span.button.root_open{background-position:-92px -54px}
.ztree li span.button.root_close{background-position:-74px -54px}
.ztree li span.button.roots_open{background-position:-92px 0}
.ztree li span.button.roots_close{background-position:-74px 0}
.ztree li span.button.center_open{background-position:-92px -18px}
.ztree li span.button.center_close{background-position:-74px -18px}
.ztree li span.button.bottom_open{background-position:-92px -36px}
.ztree li span.button.bottom_close{background-position:-74px -36px}
.ztree li span.button.noline_open{background-position:-92px -72px}
.ztree li span.button.noline_close{background-position:-74px -72px}
.ztree li span.button.root_docu{ background:none;}
.ztree li span.button.roots_docu{background-position:-56px 0}
.ztree li span.button.center_docu{background-position:-56px -18px}
.ztree li span.button.bottom_docu{background-position:-56px -36px}
.ztree li span.button.noline_docu{ background:none;}

.ztree li span.button.ico_open{margin-right:2px; background-position:-110px -16px; vertical-align:top; *vertical-align:middle}
.ztree li span.button.ico_close{margin-right:2px; background-position:-110px 0; vertical-align:top; *vertical-align:middle}
.ztree li span.button.ico_docu{margin-right:2px; background-position:-110px -32px; vertical-align:top; *vertical-align:middle}
.ztree li span.button.edit {margin-right:2px; background-position:-110px -48px; vertical-align:top; *vertical-align:middle}
.ztree li span.button.remove {margin-right:2px; background-position:-110px -64px; vertical-align:top; *vertical-align:middle}
.ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle} 

.ztree li span.button.ico_loading{margin-right:2px; background:url(/assets/js/ztree/img/loading.gif) no-repeat scroll 0 0 transparent; vertical-align:top; *vertical-align:middle}

ul.tmpTargetzTree {background-color:#FFE6B0; opacity:0.8; filter:alpha(opacity=80)}

span.tmpzTreeMove_arrow {width:16px; height:16px; display: inline-block; padding:0; margin:2px 0 0 1px; border:0 none; position:absolute;
	background-color:transparent; background-repeat:no-repeat; background-attachment: scroll;
	background-position:-110px -80px; background-image:url("/assets/js/ztree/img/zTreeStandard.png"); *background-image:url("/assets/js/ztree/img/zTreeStandard.gif")}

ul.ztree.zTreeDragUL {margin:0; padding:0; position:absolute; width:auto; height:auto;overflow:hidden; background-color:#cfcfcf; border:1px #00B83F dotted; opacity:0.8; filter:alpha(opacity=80)}
.zTreeMask {z-index:10000; background-color:#cfcfcf; opacity:0.0; filter:alpha(opacity=0); position:absolute}

/* level style*/
/*.ztree li span.button.level0 {
	display:none;
}
.ztree li ul.level0 {
	padding:0;
	background:none;
}*/
</style>
<div class="row animated fadeInRight">
    <div class="col-md-2">
        <ul id="treeDemo" class="ztree"></ul>
    </div>
    <div class="col-md-10">


<div class="panel panel-default panel-intro">
    <?php echo build_heading(); ?>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        <a href="javascript:;" data-area='["800px","800px"]' class="btn btn-success btn-add <?php echo $auth->check('examination/questions/add')?'':'hide'; ?>" title="<?php echo __('Add'); ?>" ><i class="fa fa-plus"></i> <?php echo __('Add'); ?></a>
                        <a href="javascript:;" data-area='["800px","800px"]' class="btn btn-success btn-edit btn-disabled disabled <?php echo $auth->check('examination/questions/edit')?'':'hide'; ?>" title="<?php echo __('Edit'); ?>" ><i class="fa fa-pencil"></i> <?php echo __('Edit'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-del btn-disabled disabled <?php echo $auth->check('examination/questions/del')?'':'hide'; ?>" title="<?php echo __('Delete'); ?>" ><i class="fa fa-trash"></i> <?php echo __('Delete'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-import <?php echo $auth->check('examination/questions/import')?'':'hide'; ?>" title="<?php echo __('Import'); ?>" id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false"><i class="fa fa-upload"></i> <?php echo __('Import'); ?></a>

                       

                        <a class="btn btn-success btn-recyclebin btn-dialog <?php echo $auth->check('examination/questions/recyclebin')?'':'hide'; ?>" href="kaoshi/examination/questions/recyclebin" title="<?php echo __('Recycle bin'); ?>"><i class="fa fa-recycle"></i> <?php echo __('Recycle bin'); ?></a>
                    </div>
                    <table id="table" class="table table-striped table-bordered table-hover table-nowrap"
                           data-operate-edit="<?php echo $auth->check('examination/questions/edit'); ?>" 
                           data-operate-del="<?php echo $auth->check('examination/questions/del'); ?>" 
                           width="100%">
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

</div>
</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
