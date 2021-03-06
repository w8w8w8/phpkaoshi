<?php

namespace app\api\controller;


use app\common\controller\Api;
use think\Db;

/**
 * 首页接口
 */
class Myapp extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $this->success( '请求成功', ['state'=>1, 'name'=>'刘丽丽'] );
    }


    //get 参数
    //获取计划 返回计划名称 开始时间结束时间  试卷名称 试卷id
    public function GetPlan(){
        $data = [];
        if (!empty($this->request->get('uid'))) {
            $uid = $this->request->get('uid');
            $sql=@"select fa_kaoshi_plan.id as plan_id,fa_kaoshi_plan.plan_name, fa_kaoshi_plan.starttime,fa_kaoshi_plan.endtime,
            c.exam_name, c.id as exam_id,fa_kaoshi_user_plan.`status`
            from fa_kaoshi_plan 
            left JOIN fa_kaoshi_exams c ON fa_kaoshi_plan.exam_id=c.id
            left join fa_kaoshi_user_plan on fa_kaoshi_plan.id=fa_kaoshi_user_plan.plan_id and fa_kaoshi_user_plan.user_id=" . $uid  . "
            WHERE 1 = 1 AND fa_kaoshi_plan.deletetime IS NULL";

             $data = Db::query($sql);

            //$result = array("rows" => $data);

            $this->success( '请求成功', ['state'=>1, 'rows'=>$data] );

        }
        $this->success( '请求失败', ['state'=>0, 'rows'=>$data] );
        

    }
    public function JoinPlan(){
        if (!empty($this->request->get('uid'))) {
            $uid = $this->request->get('uid');
            $plan_id = $this->request->get('plan_id');

            $sql= @"select id from fa_kaoshi_plan WHERE id=" . $plan_id . "";
            $data = Db::query($sql);
            if(count($data)>0){
                $sql= @"select id from fa_kaoshi_user_plan WHERE user_id=" . $uid  . " and plan_id=" . $plan_id . "";
                $data = Db::query($sql);
                if(count($data)==0){
                    $sql = @"insert into fa_kaoshi_user_plan (user_id,plan_id,status) 
                            values
                            ('".$uid."','".$plan_id."','0')";
                    $add = Db::query($sql);
                    $sql= @"select id from fa_kaoshi_user_plan WHERE user_id=" . $uid  . " and plan_id=" . $plan_id . "";
                    $data = Db::query($sql);
                }

                $this->success( '请求成功', ['state'=>1, 'rows'=>$data] );
            }else{
                $this->success( '请求失败', ['state'=>0, 'rows'=>'没有该计划'] );
            }

        }
        $this->success( '请求失败', ['state'=>0, 'rows'=>$data] );
        

    }


    //get 参数uid
    //获取计划 返回计划名称 开始时间结束时间  试卷名称 试卷id 如果参加过考试：starttime 考试开始时间，score成绩
    public function GetMyPlan(){
        $data = [];
        if (!empty($this->request->get('uid'))) {
            $uid = $this->request->get('uid');

            $sql=@"select fa_kaoshi_plan.id as plan_id, fa_kaoshi_plan.plan_name, fa_kaoshi_plan.starttime,fa_kaoshi_plan.endtime,
            c.exam_name, c.id as exam_id, 
            d.starttime as subexamtime,d.score
             from fa_kaoshi_user_plan
             left join fa_kaoshi_plan on fa_kaoshi_plan.id=fa_kaoshi_user_plan.plan_id
            INNER JOIN fa_kaoshi_exams c ON fa_kaoshi_plan.exam_id=c.id
             LEFT JOIN fa_kaoshi_user_exams d ON fa_kaoshi_plan.id=d.user_plan_id
             WHERE fa_kaoshi_user_plan.user_id = " . $uid  . " 
             AND fa_kaoshi_plan.deletetime IS NULL";

             $data = Db::query($sql);

            //$result = array("rows" => $data);

            $this->success( '请求成功', ['state'=>1, 'rows'=>$data] );

        }
        $this->success( '请求失败', ['state'=>0, 'rows'=>$data] );
        

    }
    //get 参数  uid、exam_id
    //获取试卷下题目 用户ID，试卷ID //返回试题类型 题目列表 类型分值
    public function GetPaper(){

        $typelist = ['单选' => 1, '多选' => 2, '判断' => 3];
        if (!empty($this->request->get('uid'))) {
            $uid = $this->request->get('uid');
            $plan_id = $this->request->get("plan_id");
            $examid = $this->request->get('exam_id');

            $exam = DB::name('KaoshiExams');
            $map['id'] = $examid;
            $row = $exam->where($map)->select();
            $questionsdata  = $row[0]['questionsdata'];

            $settingdata = $row[0]['settingdata'];
            $fenzhi = rtrim($settingdata, ',');
            
            $questionsdata  = rtrim($questionsdata, ',');
            if($questionsdata==''){
                $questionsdata = '0';
            }

            /***
            $questions = [];
            $question_obj = Db::name('KaoshiQuestions');
            $where["fa_kaoshi_questions.id"]=["in",$questionsdata];
            $questions = $question_obj
            ->where($where)
            ->select();
            $list = collection($questions)->toArray(); */


            $sql = @"SELECT fa_kaoshi_questions.*, u.user_answer,u.user_score,u.user_result
            FROM fa_kaoshi_questions
            LEFT JOIN fa_kaoshi_user_question u ON fa_kaoshi_questions.id=u.question_id and u.user_id='".$uid."'
            and u.exam_id=".$examid."
            WHERE fa_kaoshi_questions.id IN(".$questionsdata.")";

            //print_r($sql);

            $list = Db::query($sql);

            $this->success('请求成功', ['state'=>1, 'rows'=>$list , 'typelist'=>$typelist, 'fenzhi'=>$fenzhi ] );

        }
        $this->success( '请求成功', ['state'=>1, 'rows'=>[], 'typelist'=>$typelist ] );

    }


    //交卷 用户ID，题目ID，所选答案（字符串）
    public function SubPaper(){


        $json_string=file_get_contents("php://input");
        $list = json_decode($json_string, true);


        $user_id = $list["user_id"];
        $plan_id = $list["plan_id"];
        $exam_id = $list["exam_id"];
        $score = $list["score"];
        $starttime = $list["starttime"];
        $usetime = $list["usetime"];

        $question = $list["question"];

        //查询user_plan_id
        $exam = DB::name('KaoshiUserPlan');
        $map['user_id'] = $user_id;
        $map['plan_id'] = $plan_id;
        $row = $exam->where($map)->select();
        $user_plan_id  = $row[0]['id'];

        
        //删除以前的考试结果
        Db::startTrans();
        try {

            $kaoshi_user_exams = Db::name('kaoshi_user_exams')->where('user_plan_id', 'in', $user_plan_id)->delete();
            $kaoshi_user_exams = Db::name('kaoshi_user_question')->where($map)->delete();
            Db::commit();


        } catch (PDOException $e) {
            Db::rollback();
            $this->error($e->getMessage());
        } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }


        $user_exams_obj = new  \addons\kaoshi\model\examination\KaoshiUserExams;
        $add = [
            'user_plan_id' => $user_plan_id,
            'questionsdata' => json_encode($question),
            'score' =>$score,
            'usetime' => $usetime,
            'starttime' => $starttime,
            'lasttime' => time(),
            'real_answersdata' => '',
        ];
        $result = $user_exams_obj->save($add);


        $sql = '';
        foreach ($question as $key => $value) {
            //print_r($key['question_id']."=>".$value['question_id']."<br>");
            //print_r($key['user_id']."=>".$value['user_id']."<br>");
            //print_r($key['user_answer']."=>".$value['user_answer']."<br>");
            //user_score,user_result

            $sql = @"insert into fa_kaoshi_user_question (exam_id,plan_id,question_id,user_answer,user_id,user_score,user_result) 
            values
            ('".$exam_id."','".$plan_id."','".$value['question_id']."','".$value['user_answer']."','".$user_id."','".$value['user_score']."','".$value['user_result']."')";

            $data = Db::query($sql);
            //print_r($sql);
        }
        


        $this->success( '成功', ['state'=>1, 'list'=> 'OK' ] );

    }


    //记录学习时间 用户ID，课程id，学习时长（秒）
    public function SaveLearnTime(){
        if (!empty($this->request->get('uid'))) {
            $user_id = $this->request->get('uid');
            $course_id = $this->request->get('course_id');
            $learn_time = $this->request->get('learn_time');

            $user_learn_obj = new  \addons\kaoshi\model\examination\KaoshiUserLearn;
            $add = [
                'user_id' => $user_id,
                'course_id' => $course_id,
                'learn_time' => $learn_time,
                'addtime' => time(),
            ];
            $result = $user_learn_obj->save($add);

            $this->success( '请求成功', ['state'=>1, 'list'=>'ok'] );
        }
        $this->error(__('参数错误'));
        

    }
    //获取用户的学习总时长和次数
    public function GetMyLearnTime(){

        if (!empty($this->request->get('uid'))) {
            $user_id = $this->request->get('uid');
            
            $sql="select sum(learn_time) as timelength,count(id) as rowcount from fa_kaoshi_user_learn where user_id='".$user_id."'";

            $data = Db::query($sql);

            $this->success( '请求成功', ['state'=>1, 'rows'=>$data] );
        }
        $this->error(__('参数错误'));
    }

    //记录学过知识点 用户ID，知识点id，知识点pid默认为0
    public function SaveLearnedKnow(){


        $json_string=file_get_contents("php://input");
        

        if (!empty($json_string)) {
            
            $list = json_decode($json_string, true);

            $user_id = $list["uid"];
            $knows = $list["knows"];

            //查询知识点
            foreach ($knows as $key => $value) {

                $sql = @"select id from fa_kaoshi_know where knowid='".$value['knowid']."'";
                $data = Db::query($sql);
                if(count($data)==0){
                    $sql = @"insert into fa_kaoshi_know (knowid,knowtitle,pid,knowdesc,url) 
                            values
                            ('".$value['knowid']."','".$value['knowtitle']."','".$value['pid']."','','".$value['url']."')";
                    $add = Db::query($sql);

                    $sql = @"select id from fa_kaoshi_know where knowid='".$value['knowid']."'";
                    $data = Db::query($sql);
                }

                $kid = $data[0]['id'];
                $sql = @"delete from fa_kaoshi_user_know where know_id='".$kid."'";
                $del = Db::query($sql);

                $sql = @"insert into fa_kaoshi_user_know (know_id,user_id,learned) 
                            values
                            ('".$kid."','".$user_id."','".$value['learned']."')";
                $add = Db::query($sql);

    
                //$data = Db::query($sql);
                //print_r($data[0]['id']);
            }
         

            $this->success( '请求成功', ['state'=>1, 'list'=> $list] );
        }
        $this->error(__('参数错误'));
    }

    //POST 参数： 试卷ID，知识点列表 [{"knowname":"111"},{"knowname":"222"}]
    //根据试卷ID 判断是否存在知识点，不存在则写入
    public function GeyMyKnows(){
        

        if (!empty($this->request->get('uid'))) {
            $user_id = $this->request->get('uid');
            
            $sql=@"select uk.learned,k.knowid,k.knowtitle,k.pid,k.url
            from fa_kaoshi_user_know uk
            left join fa_kaoshi_know k on k.id = uk.know_id
            where uk.user_id='".$user_id."'";

            $data = Db::query($sql);

            $this->success( '请求成功', ['state'=>1, 'rows'=>$data] );
        }
        $this->error(__('参数错误'));

    }


    public function GetAllStuLearnTime(){

        try{

            $sql=@"select fa_user.username,fa_user.nickname,fa_user.id as user_id, 
            (select sum(learn_time) from fa_kaoshi_user_learn where 
            fa_kaoshi_user_learn.user_id = fa_user.id) as timelength,
            (select count(id) from fa_kaoshi_user_learn where 
            fa_kaoshi_user_learn.user_id = fa_user.id) as rowcount
            from fa_user";


            $data = Db::query($sql);

            $this->success( '请求成功', ['state'=>1, 'rows'=>$data] );
        }
        catch (Exception $e) {
            //$this->error($e->getMessage());

            $this->error(__('参数错误' + getMessage()));
        }
        
    }


    public function GetRankByPlanid(){

        try{

            if (!empty($this->request->get('plan_id'))) {
                $planid = $this->request->get('plan_id');

                $sql=@"select fa_kaoshi_user_plan.*,fa_user.username,fa_user.nickname, IFNULL(fa_kaoshi_user_exams.score,0)  as score
                from fa_kaoshi_user_plan
                left join  fa_kaoshi_user_exams on fa_kaoshi_user_exams.user_plan_id = fa_kaoshi_user_plan.id 
                left join fa_user on fa_user.id = fa_kaoshi_user_plan.user_id
                 where fa_kaoshi_user_plan.plan_id=".$planid ."
                order by fa_kaoshi_user_exams.score desc";

                $data = Db::query($sql);

                $sql = @"select fa_kaoshi_plan.plan_name,fa_kaoshi_plan.exam_id,fa_kaoshi_plan.subject_id
                , fa_kaoshi_subject.subject_name
                from fa_kaoshi_plan
                left join fa_kaoshi_subject on fa_kaoshi_subject.id = fa_kaoshi_plan.subject_id
                where fa_kaoshi_plan.id=".$planid ." ";

                $plan = Db::query($sql);

                $this->success( '请求成功', ['state'=>1, 'rows'=>$data, 'plan'=>$plan] );

            }else{

                $this->error(__('参数错误'));
            }
        }
        catch (Exception $e) {
            //$this->error($e->getMessage());

            $this->error(__('参数错误' + getMessage()));
        }
        
    }


    public function GetRankByExamid(){

        try{

            if (!empty($this->request->get('exam_id'))) {
                $examid = $this->request->get('exam_id');

                $sql=@"select fa_kaoshi_user_plan.*,fa_user.username,fa_user.nickname, IFNULL(fa_kaoshi_user_exams.score,0) as score
                from fa_kaoshi_user_plan
                left join  fa_kaoshi_user_exams on fa_kaoshi_user_exams.user_plan_id = fa_kaoshi_user_plan.id 
                left join fa_user on fa_user.id = fa_kaoshi_user_plan.user_id
                left join fa_kaoshi_plan on fa_kaoshi_plan.id = fa_kaoshi_user_plan.plan_id
                 where fa_kaoshi_plan.exam_id=".$examid ."
                order by fa_kaoshi_user_exams.score desc";

                $data = Db::query($sql);

                $sql = @"select fa_kaoshi_plan.plan_name,fa_kaoshi_plan.exam_id,fa_kaoshi_plan.subject_id
                , fa_kaoshi_subject.subject_name
                from fa_kaoshi_plan
                left join fa_kaoshi_subject on fa_kaoshi_subject.id = fa_kaoshi_plan.subject_id
                where fa_kaoshi_plan.exam_id=".$examid ." ";

                $plan = Db::query($sql);

                $this->success( '请求成功', ['state'=>1, 'rows'=>$data, 'plan'=>$plan] );

            }else{

                $this->error(__('参数错误'));
            }
        }
        catch (Exception $e) {
            //$this->error($e->getMessage());

            $this->error(__('参数错误' + getMessage()));
        }
        
    }


    




}