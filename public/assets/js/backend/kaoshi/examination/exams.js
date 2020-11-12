define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    
    //
    $('#c-type').on('change',function (obj) {
        var select_type = $(this).val();
        switch(select_type){
            case "1":
                $("#xuanze").hide();
                $("#suiji").show();
                break;
            case "2":
                getallquestion();
                $("#xuanze").show();
                $("#suiji").hide();
                break;
            case "3":
                
                break;
        }
    });
    


    function getallquestion(){
        //获取选中的条目ID集合
        var url = 'kaoshi/examination/exams/getallquestion';//弹出窗口 add.html页面的（fastadmin封装layer模态框将以iframe的方式将add输出到index页面的模态框里）
        //Fast.api.open(url);
        $.getJSON(url,function(result){
            console.log(result);
            var strHtml="<table id='qtable' class=\"table table-striped\">";
            $.each(result.rows, function(i, field){
                strHtml +="<tr id='row_"+field.id+"' calss='qtype_"+field.type+"'><td><div><input name='row[question]' type='checkbox' value='"+field.id+"_"+field.type+"' /></div></td><td><div class='examselectq'>"+field.question+"</div></td></tr> ";
            });
            strHtml +="</table>";
            $("#qlist").html(strHtml);

            $("input[name='row[question]']").click(function(){
                chkthis(this);
            });
            $("#calresult").html("");
            $("#selectresult").val("");
        });
    }
    function chkthis(obj){
        var ss = $("#selectresult").val();
        if(ss ==""){
            ss ="[]";
        }
        var qlist = JSON.parse(ss);
        var qarray = $(obj).val().split('_');
        var qid = {
            "type":qarray[1],
            "id":qarray[0]
        };
        
        var sr = qlist.filter(function(item){return item.id==qarray[0]});
        if($(obj).is(':checked')) {
            if(sr.length>0){}
            else{
                qlist.push(qid);
            }
        }else{

            qlist = qlist.filter(function(item) {
                return item.id != qarray[0];
            });
        }
        //计算选择结果
        var total=0,total1 = 0,total2 = 0,total3 = 0, num1=0, num2=0, num3=0;
        for(var i=0;i<qlist.length;i++){
            if(qlist[i].type=="1"){
                total1 += parseInt($("#qtype1").val());
                num1++;
            }
            if(qlist[i].type=="2"){
                total2 += parseInt($("#qtype2").val());
                num2++;
            }
            if(qlist[i].type=="3"){
                total3 += parseInt($("#qtype3").val());
                num3++;
            }
        }
        total = total1+total2+total3;

        //calresult
        $("#calresult").html("共计：单选"+num1+"道，多选"+num2+"道， 判断"+num3+"道。总分"+total);
        $("#c-score").val(total);
        $("#selectresult").val(JSON.stringify(qlist));
    }
    
    $(document).on("fa.event.appendfieldlist", ".btn-append", function(){
        Form.events.selectpicker($(".fieldlist"));
    });
    $(function () {
        $("body").delegate(".scoreset","input",function(){
            var score = getscore();
            if(isNaN(score)){
                score = 0;
            }
            $('[name="row[score]"]').val(score);
        });


    });
    function getscore(length) {
        var score = 0;
        $('.mark').each(function () {

            score+=$(this).val() * $(this).parent().prev().children('.number').val();
        });

        return score;
    }
    var Controller = {

        index: function () {

            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'kaoshi/examination/exams/index' + location.search,
                    add_url: 'kaoshi/examination/exams/add',
                    edit_url: 'kaoshi/examination/exams/edit',
                    del_url: 'kaoshi/examination/exams/del',
                    multi_url: 'kaoshi/examination/exams/multi',
                    getquestion_url: 'kaoshi/examination/exams/getquestion',
                    table: 'exams',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {
                            field: 'buttons',
                            width: "120px",
                            title: __('预览'),
                            operate:false,
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'questions',
                                    text: __('预览'),
                                    title: __('随机考题预览'),
                                    classname: 'btn btn-xs btn-primary btn-dialog',
                                    icon: 'fa fa-eye',
                                    url: 'kaoshi/examination/exams/getquestion'
                                },],
                            formatter: Table.api.formatter.buttons
                        },
                        {field: 'id', title: __('Id')},
                        {field: 'admin.username', title: __('username')},
                        {field: 'subject.subject_name', title: __('Subject_name')},
                        {field: 'exam_name', title: __('Exam_name')},
                        {field: 'score', title: __('Score')},
                        {field: 'pass', title: __('Pass')},
                        {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2')}, formatter: Table.api.formatter.normal},
                        {field: 'keyword', title: __('Keyword')},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
            table.on('post-body.bs.table', function (e, settings, json, xhr) {
                $(".btn-editone").data("area", ["900px","600px"]);
            });

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
                url: 'kaoshi/examination/exams/recyclebin' + location.search,
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
                                    url: 'kaoshi/examination/exams/restore',
                                    refresh: true
                                },
                                {
                                    name: 'Destroy',
                                    text: __('Destroy'),
                                    classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
                                    icon: 'fa fa-times',
                                    url: 'kaoshi/examination/exams/destroy',
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

            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        getquestion:function () {
            Controller.api.bindevent();            
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
