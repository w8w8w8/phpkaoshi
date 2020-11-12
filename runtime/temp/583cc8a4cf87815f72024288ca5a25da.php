<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"D:\phpstudy_pro\WWW\public/../application/admin\view\kaoshi\examination\exams\edit.html";i:1605082313;s:62:"D:\phpstudy_pro\WWW\application\admin\view\layout\default.html";i:1602168705;s:59:"D:\phpstudy_pro\WWW\application\admin\view\common\meta.html";i:1602168705;s:61:"D:\phpstudy_pro\WWW\application\admin\view\common\script.html";i:1602168705;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Subject_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-subject_id" data-rule="required" data-field="subject_name" data-source="kaoshi/subject/index" class="form-control selectpage" name="row[subject_id]" type="text" value="<?php echo htmlentities($row['subject_id']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Exam_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-exam_name" data-rule="required" class="form-control" name="row[exam_name]" type="text" value="<?php echo htmlentities($row['exam_name']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-type" data-rule="required" class="form-control selectpicker" name="row[type]">
                <?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): if( count($typeList)==0 ) : echo "" ;else: foreach($typeList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"1"))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group" id="suiji">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Setting'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <dl class="fieldlist" data-template="settingdata" data-name="row[settingdata]">
                <dd>
                    <ins>题型</ins>
                    <ins>难度</ins>
                    <ins>数量</ins>
                    <ins>分值</ins>
                </dd>
                <dd><a href="javascript:;" class="btn btn-sm btn-success btn-append"><i class="fa fa-plus"></i> <?php echo __('Append'); ?></a></dd>
                <!--请注意 dd和textarea间不能存在其它任何元素，实际开发中textarea应该添加个hidden进行隐藏-->
                <textarea name="row[settingdata]" class="form-control hide" cols="30" rows="5"><?php echo $row['settingdata']; ?></textarea>
            </dl>
            <script id="settingdata" type="text/html">
                <dd class="form-inline setting-row">
                    <ins>
                        <select name="<%=name%>[<%=index%>][type]" id="" class="form-control selectpicker">
                            <option value="1" <%if(row.type==1){%>selected<%}%>>单选题</option>
                            <option value="2" <%if(row.type==2){%>selected<%}%>>多选题</option>
                            <option value="3" <%if(row.type==3){%>selected<%}%>>判断题</option>
                        </select>
                    </ins>
                    <ins>
                        <select name="<%=name%>[<%=index%>][level]" id="" class="form-control selectpicker">
                            <option value="1" <%if(row.level==1){%>selected<%}%>>易</option>
                            <option value="2" <%if(row.level==2){%>selected<%}%>>中</option>
                            <option value="3" <%if(row.level==3){%>selected<%}%>>难</option>
                        </select>
                    </ins>
                    <ins><input type="number" step="1" min='1' name="<%=name%>[<%=index%>][number]" class="form-control number scoreset" value="<%=row.number%>" placeholder="数量"/></ins>
                    <ins><input type="number" step="1" min='1' name="<%=name%>[<%=index%>][mark]" class="form-control mark scoreset" value="<%=row.mark%>" placeholder="分值"/></ins>
                    <!--下面的两个按钮务必保留-->
                    <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span>
                    <span class="btn btn-sm btn-primary btn-dragsort"><i class="fa fa-arrows"></i></span>
                </dd>
            </script>
        </div>
    </div>

    <div  class="form-group" id="xuanze" style="display: none;">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Setting'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div> 
                <div class="form-group">
                    <div class="col-sm-2">
                      <div class="checkbox">
                        <label id="filterchk1">
                          <input type="checkbox" name='qt' value="1" checked> 单选
                        </label> 
                      </div>
                      
                    </div>
                    <div class="col-sm-2">分值<input type="number" step="1" min="1" id="qtype1" name="row[qtype1]" class="form-control mark" value="0" placeholder="分值"></div>
                    <div class="col-sm-2">
                        <div class="checkbox">
                          <label id="filterchk2">
                            <input type="checkbox" value="2" checked> 多选
                          </label>
                          
                        </div>
                      </div>
                    <div class="col-sm-2">分值<input type="number" step="1" min="1" id="qtype2" name="row[qtype2]" class="form-control" value="0" placeholder="分值"></div>
                    <div class="col-sm-2">
                    <div class="checkbox">
                        <label id="filterchk3">
                        <input type="checkbox" value="3" checked> 判断
                        </label>
                    </div>
                    </div>
                    <div class="col-sm-2">分值<input type="number" step="1" min="1" id="qtype3" name="row[qtype3]" class="form-control" value="0" placeholder="分值"></div>
                </div>
            </div>

            <div>选择结果：<span id="calresult"></span>
                <textarea id='selectresult' name="row[selectqlist]" class="form-control hide" cols="30" rows="3">[]</textarea></div>
            <div style="width: 550px;height: 500px;overflow-y: auto;">
            
                <div id="qlist"></div>
            </div>
            <!----<a href="javascript:;" class="btn btn-sm btn-success btn-selectquestion"><i class="fa fa-plus"></i> 选择试题</a>---->
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Score'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-score"  class="form-control" name="row[score]" readonly="true"  type="number" step="1" min="0" value="<?php echo htmlentities($row['score']); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Pass'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-pass"  class="form-control" name="row[pass]" type="number" step="1" min="0" value="<?php echo htmlentities($row['pass']); ?>">
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
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Keyword'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-keyword" class="form-control" name="row[keyword]" type="text" value="<?php echo htmlentities($row['keyword']); ?>">
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
