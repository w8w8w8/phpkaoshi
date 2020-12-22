define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {



    $('#c-type').on('change',function (obj) {
        var select_type = $(this).val();
        switch(select_type){
            case "1":
                $('.fieldlist2').addClass('hidden');
                $('.fieldlist0').removeClass('hidden');
                $('.fieldlist1').addClass('hidden');
                break;
            case "2":
                $('.fieldlist2').addClass('hidden');
                $('.fieldlist0').addClass('hidden');
                $('.fieldlist1').removeClass('hidden');
                break;
            case "3":
                case "2":
                $('.fieldlist2').removeClass('hidden');
                $('.fieldlist0').addClass('hidden');
                $('.fieldlist1').addClass('hidden');
                break;
        }
    });
    var Controller = {
        index: function () {
            var _subject_id=0;
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'kaoshi/examination/questions/index' + location.search,
                    add_url: 'kaoshi/examination/questions/add',
                    edit_url: 'kaoshi/examination/questions/edit',
                    del_url: 'kaoshi/examination/questions/del',
                    multi_url: 'kaoshi/examination/questions/multi',
                    import_url: 'kaoshi/examination/questions/import',
                    table: 'questions',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'admin.username', title: __('username'),formatter:Table.api.formatter.search},
                        {field: 'subject.subject_name', title: __('Subject_name'),formatter:Table.api.formatter.search},
                        {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2'),"3":__('Type 3')}, formatter: Table.api.formatter.normal},
                        {field: 'selectnumber', title: __('Selectnumber'),formatter:Table.api.formatter.search},
                        {field: 'answer', title: __('Answer')},
                        {field: 'question', title: __('question'),
                                cellStyle : function(value, row, index, field){
                                    return {
                                        css: {"min-width": "100px",
                                            "white-space": "nowrap",
                                            "text-overflow": "ellipsis",
                                            "overflow": "hidden",
                                            "max-width":"250px"
                                        }
                                    };
                                }
                        },
                        {field: 'annex', title: __('annex'),formatter: Controller.api.formatter.thumb, operate: false},
                        {field: 'level', title: __('Level'), searchList: {"1":__('Level 1'),"2":__('Level 2'),"3":__('Level 3')}, formatter: Table.api.formatter.normal},
                        {field: 'status', title: __('status'), searchList: {"1":__('status 1'),"2":__('status 2')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ],
                queryParams: function(params){
                    if(_subject_id!==0){
                    console.log(params);
                    var filter = params.filter ? JSON.parse(params.filter) : {}; //判断当前是否还有其他高级搜索栏的条件
                    var op = params.op ? JSON.parse(params.op) : {};  //并将搜索过滤器 转为对象方便我们追加条件
                    filter.subject_id= _subject_id;     //将透传的参数 Config.group_id，追加到搜索条件中
                    op.subject_id= "=";  //group_id的操作方法的为 找到相等的
                    params.filter = JSON.stringify(filter); //将搜索过滤器和操作方法 都转为JSON字符串
                    params.op = JSON.stringify(op);
                    //如果希望忽略搜索栏搜索条件,可使用
                    //params.filter = JSON.stringify({url: 'login'});
                    //params.op = JSON.stringify({url: 'like'});
                    console.log(params);
                    }
                    return params;
                }

            });

            // 为表格绑定事件
            Table.api.bindevent(table);
            table.on('post-body.bs.table', function (e, settings, json, xhr) {
                $(".btn-editone").data("area", ["800px","800px"]);
            });


            require(['jquery.ztree.core'], function (ztree) {

                var zNodes = [];
                zNodes.push({name: "全部试题", id: 0, children: []});
                 // kaoshi/subject/index
                //zNodes = [];
                $.ajax({url:"kaoshi/subject/getSubTree",async: false,success:function(result){
                    zNodes[0].children = result;
                }});
                
        
                var setting = {
                    async: {
                        enable: false,
                        url:"kaoshi/subject/index", //没点击一次节点AJAX 都会与此路径交互一次
                        autoParam:[ "id", "name" ], //ajax提交的时候，传的是id值
                    },
                    data: {
                        simpleData: {
                            enable: false,
                            idKey: "id",
                            pIdKey: "pId",
                            rootPId: 0
                        }
                    },
                    callback: {
                        onClick: zTreeOnClick
                    }
                };
                var zTreeObj;
               
               console.log(JSON.stringify(zNodes));
        
                $(document).ready(function(){
                    zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
                    var nodes = zTreeObj.getNodes();
                        if (nodes.length>0) {
                            for(var i=0;i<nodes.length;i++){
                                zTreeObj.expandNode(nodes[i], true, false, false);//默认展开第一级节点
                            }
        
                    }
                });
            });
            
            function zTreeOnClick(event, treeId, treeNode){
                //alert(treeNode.tId + ", " + treeNode.name + ", " + treeNode.id);
                //alert(location.search);
                _subject_id = treeNode.id;
                Controller.api.refresh(table);
            }

        },
        recyclebin: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    'dragsort_url': ''
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: 'kaoshi/examination/questions/recyclebin' + location.search,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {
                            field: 'deletetime',
                            title: __('Deletetime'),
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            formatter: Table.api.formatter.datetime
                        },
                        {
                            field: 'operate',
                            width: '130px',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'Restore',
                                    text: __('Restore'),
                                    classname: 'btn btn-xs btn-info btn-ajax btn-restoreit',
                                    icon: 'fa fa-rotate-left',
                                    url: 'kaoshi/examination/questions/restore',
                                    refresh: true
                                },
                                {
                                    name: 'Destroy',
                                    text: __('Destroy'),
                                    classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
                                    icon: 'fa fa-times',
                                    url: 'kaoshi/examination/questions/destroy',
                                    refresh: true
                                }
                            ],
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent($("form[role=form]"));
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
               Form.api.bindevent($("form[role=form]"));
            },
            formatter: {
                thumb: function (value, row, index) {
                    if(typeof (value) == 'string' && value.length > 0){
                        return '<a href="' + value + '" target="_blank"><img src="' + value +'" alt="" style="max-height:90px;max-width:120px"></a>';
                    }else{
                        return "";
                    }
                },
                url: function (value, row, index) {
                    return '<a href="' + value + '" target="_blank" class="label bg-green">' + value + '</a>';
                },
            },
            refresh: function (table) {
                //刷新
                $(".btn-refresh").trigger("click");

            }
        }
    };

    return Controller;
});