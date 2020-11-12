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

            $questions = [];
            $question_obj = Db::name('KaoshiQuestions');
            $where["id"]=["in",$questionsdata];
            $questions = $question_obj
            ->where($where)
            ->select();

            $list = collection($questions)->toArray();


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

    //POST 参数： 试卷ID，知识点列表 [{"knowname":"111"},{"knowname":"222"}]
    //根据试卷ID 判断是否存在知识点，不存在则写入
    public function AddKnowledge(){

        $this->success( '请求成功', ['state'=>1, 'name'=>'刘丽丽'] );

    }
    

    

    //记录学习时间 用户ID，课程id，学习时长（秒）
    public function SaveLearnTime(){

        $this->success( '请求成功', ['state'=>1, 'name'=>'刘丽丽'] );

    }

    //记录学过知识点 用户ID，知识点id，知识点pid默认为0
    public function SaveLearnedKnow(){

        $this->success( '请求成功', ['state'=>1, 'name'=>'刘丽丽'] );

    }




}