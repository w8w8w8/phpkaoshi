<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:91:"D:\phpstudy_pro\WWW\public/../application/admin\view\kaoshi\examination\questions\edit.html";i:1604814661;s:62:"D:\phpstudy_pro\WWW\application\admin\view\layout\default.html";i:1602168705;s:59:"D:\phpstudy_pro\WWW\application\admin\view\common\meta.html";i:1602168705;s:61:"D:\phpstudy_pro\WWW\application\admin\view\common\script.html";i:1602168705;}*/ ?>
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
    ins{
        text-align: center;
    }
</style>

<form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Subject_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-subject_id" data-rule="required" data-field="subject_name" data-source="kaoshi/subject/index" class="form-control selectpage" name="row[subject_id]" type="text" value="<?php echo htmlentities($row['subject_id']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Question'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-question" data-rule="required" class="form-control editor" rows="5" name="row[question]" cols="50"><?php echo htmlentities($row['question']); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __("Annex"); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <input type="text" name="row[annex]" id="c-annex" class="form-control" readonly/>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">

            <button id="plupload-annex" class="btn btn-danger plupload" data-multiple="false" data-input-id="c-annex" ><i class="fa fa-upload"></i> 上传</button>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-type" data-rule="required" class="form-control selectpicker" name="row[type]">
                <?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): if( count($typeList)==0 ) : echo "" ;else: foreach($typeList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['type'])?$row['type']:explode(',',$row['type']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Select'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
           
        

            <?php if(is_array($selectdata) || $selectdata instanceof \think\Collection || $selectdata instanceof \think\Paginator): if( count($selectdata)==0 ) : echo "" ;else: foreach($selectdata as $k=>$type): ?>
                 <dl  data-template="answer<?php echo $k; ?>" class="fieldlist fieldlist<?php echo $k; ?> <?php echo $k+1!=$row['type']?'hidden' : ''; ?>" data-name="row[selectdata<?php echo $k; ?>]" data-listidx="0">
                 <dd><ins>选项</ins><ins>答案</ins><ins>正确答案</ins></dd>
                <?php if($k == '2'): if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): if( count($type)==0 ) : echo "" ;else: foreach($type as $j=>$option): ?> 
                <dd class="form-inline">
                    <ins><input type="text" name="row[selectdata<?php echo $k; ?>][<?php echo $j; ?>][key]" class="form-control" placeholder="选项" size="10" value="<?php echo $option['key']; ?>"  <?php echo $k==2?'readonly' : ''; ?>/></ins>
                    <ins><input type="text" name="row[selectdata<?php echo $k; ?>][<?php echo $j; ?>][value]" class="form-control" placeholder="" value="<?php echo $option['value']; ?>"  <?php echo $k==2?'readonly' : ''; ?>/></ins>
                    
                    <ins><input type="radio" name="row[answer<?php echo $k; ?>]" value="<?php echo $option['key']; ?>"  <?php echo in_array($option['key'], $row['answer'])?'checked':''; ?>/></ins>
                    <!--下面的两个按钮务必保留-->
                    <?php if($k != '2'): ?>
                    <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span>
                    <span class="btn btn-sm btn-primary btn-dragsort"><i class="fa fa-arrows"></i></span>

                    <?php endif; ?>
                </dd>
                <?php endforeach; endif; else: echo "" ;endif; endif; if($k != '2'): ?>

                <dd><a href="javascript:;" class="btn btn-sm btn-success btn-append"><i class="fa fa-plus"></i> 追加</a></dd>
            <?php endif; ?>
                <textarea name="row[selectdata<?php echo $k; ?>]" class="form-control hide" cols="30" rows="5"><?php echo json_encode($type); ?></textarea>
            </dl>
            <?php endforeach; endif; else: echo "" ;endif; ?>






            <!--单选题 -->
            <script id="answer0" type="text/html">
                
                <dd class="form-inline">
                    <ins><input type="text" name="<%=name%>[<%=index%>][key]" class="form-control" placeholder="选项" size="10" value="<%=row.key%>"/></ins>
                    <ins><input type="text" name="<%=name%>[<%=index%>][value]" class="form-control" placeholder="" value="<%=row.value%>"/></ins>
                    <ins><input type="radio" name="row[answer0]" value="<%=row.key%>" <%=row.checked%>/></ins>
                    <!--下面的两个按钮务必保留-->
                    <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span>
                    <span class="btn btn-sm btn-primary btn-dragsort"><i class="fa fa-arrows"></i></span>
                </dd>
            </script>

            <!--多选题 -->
            <script id="answer1" type="text/html">
                
                <dd class="form-inline">
                    <ins><input type="text" name="<%=name%>[<%=index%>][key]" class="form-control" placeholder="选项" size="10"  value="<%=row.key%>"/></ins>
                    <ins><input type="text" name="<%=name%>[<%=index%>][value]" class="form-control" placeholder=""  value="<%=row.value%>"/></ins>
                    <ins><input type="checkbox" name="row[answer1][]" value="<%=row.key%>" <%=row.checked%>/></ins>
                    <!--下面的两个按钮务必保留-->
                    <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span>
                    <span class="btn btn-sm btn-primary btn-dragsort"><i class="fa fa-arrows"></i></span>
                </dd>
            </script>
            <div style="color:red;">*请选中正确答案</div>


        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Describe'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-describe" class="form-control " rows="5" name="row[describe]" cols="50"><?php echo htmlentities($row['describe']); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Level'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-level" data-rule="required" class="form-control selectpicker" name="row[level]">
                <?php if(is_array($levelList) || $levelList instanceof \think\Collection || $levelList instanceof \think\Paginator): if( count($levelList)==0 ) : echo "" ;else: foreach($levelList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['level'])?$row['level']:explode(',',$row['level']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>

        <div class="col-xs-12 col-sm-8">
            <select  id="c-status" data-rule="required" class="form-control selectpicker" name="row[status]">

            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
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
