<?php

namespace app\admin\controller\kaoshi\examination;

use app\common\controller\Backend;
use think\Db;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Exams extends Backend
{

    /**
     * Exams模型对象
     * @var \app\admin\model\kaoshi\examination\KaoshiExams
     */
    protected $model = null;
    protected $dataLimit = 'auth';
    protected $dataLimitField = 'admin_id';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\kaoshi\examination\KaoshiExams;
        $this->view->assign("typeList", $this->model->getTypeList());
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 查看
     */
    public function index()
    {
        $this->dataLimit = false;
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with(['subject', 'admin'])
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['subject', 'admin'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach ($list as $row) {


            }
            $list = collection($list)->toArray();

            //测试执行自定义sql
            $sql = "select * from fa_kaoshi_exams";
            $data = Db::query($sql);

            $result = array("total" => $total, "rows" => $list, "data" => $data);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;

                $question_obj = new \app\admin\model\kaoshi\examination\KaoshiQuestions;
                $LevelList = $question_obj->getLevelList();//试题类型列表
                $typenum = [];
                foreach ($LevelList as $key => $value) {
                    $typenum[$key] = Db::name('KaoshiQuestions')
                        ->where(['deletetime' => NULL, 'subject_id' => $params['subject_id'], 'level' => $key, 'status' => 1])
                        ->group('type')
                        ->column(['type', 'count(id)' => 'num']);
                }


                $namearr = $this->model->where(['deletetime' => NULL, 'subject_id' => $params['subject_id']])->column('exam_name');
                if (in_array($params['exam_name'], $namearr)) {
                    $this->error('卷名已存在！');

                }
                

                if($params['type'] == 1){
                    //如果试卷类型为1 随机组卷 则保持原来的不变，验证
                    $settingdata = json_decode($params['settingdata'], true);
                    if (count($settingdata) < 1) {
                        $this->error('请添加考卷设置');

                    }
                    $params['score'] = 0;
                    foreach ($settingdata as $key => $value) {
                        $num = intval($value['number']);
                        $mark = intval($value['mark']);
                        if (intval($value['number']) <= 0) {
                            $this->error('考卷设置第' . ($key + 1) . '项数量需大于0');
                        }
                        if (intval($value['mark']) <= 0) {
                            $this->error('考卷设置第' . ($key + 1) . '项分值需大于0');
                        }

                        if (is_array($typenum[$value['level']])) {
                            if (count($typenum[$value['level']]) == 0) {
                                $this->error('考卷设置第' . ($key + 1) . '项，该科目无[' . $LevelList[$value['level']] . ']级别题目');
                            }
                            if (!isset($typenum[$value['level']][$value['type']])) {
                                $this->error('考卷设置第' . ($key + 1) . '项，[' . $LevelList[$value['level']] . ']级别题目没有该题型');
                            } elseif ($typenum[$value['level']][$value['type']] < $value['number']) {
                                $this->error('考卷设置第' . ($key + 1) . '项数量过多[题库仅' . $typenum[$value['level']][$value['type']] . '题]');
                            }
                        }

                        $params['score'] += $num * $mark;

                    }

                    $questions = [];
                    $question_obj = Db::name('KaoshiQuestions');
                    //随机出题固化在试卷表中
                    foreach ($settingdata as $key => $value) {
                        $map['type'] = $value['type'];
                        $map['subject_id'] = $params['subject_id'];
                        $map['level'] = $value['level'];
                        $map['status'] = 1;
                        $map['deletetime'] = null;
                        $arr = $question_obj->where($map)->select();
            
                        $rand_arr = array_rand($arr, intval($value['number']));
                        if (is_array($rand_arr)) {
                            foreach ($rand_arr as $k => $v) {
                                $arr[$v]['selectdata'] = json_decode($arr[$v]['selectdata'], true);
                                if ($value['type'] == 2) {
                                    $arr[$v]['answer'] = explode(',', $arr[$v]['answer']);
                                }
                                $questions[$key][$k] = $arr[$v];
                            }
            
                            shuffle($questions[$key]);
                        } else {
                            $arr[$rand_arr]['selectdata'] = json_decode($arr[$rand_arr]['selectdata'], true);
                            if ($value['type'] == 2) {
                                $arr[$rand_arr]['answer'] = explode(',', $arr[$rand_arr]['answer']);
            
                            }
                            $questions[$key][] = $arr[$rand_arr];
                        }
            
                    }
                    
                    $qids="";
                    foreach($questions as $k=>$val)
                    {
                        foreach($val as $item=>$item_val){
                              $qids .= $item_val['id'] . ",";
                        }
                    }
                    $params['questionsdata']= rtrim($qids, ',');

                }
                if($params['type'] == 2){
                //如果是选择题目出卷，则直接写入
                    $qlist = json_decode($params['selectqlist'], true);
                    if (count($qlist) < 1) {
                        $this->error('自定义试卷，请选择题目');
                    }
                    $qids="";
                    foreach ($qlist as $key => $value) {
                        $qtype = intval($value['type']);
                        $qid = intval($value['id']);
                        $qids .= $qid . ",";

                    }
                    $params['questionsdata']= rtrim($qids, ',');
                    $params['settingdata'] = $params['qtype1'] . "," . $params['qtype2'] . "," . $params['qtype3'];//暂时这样定义  1单选 2多选 3判断 按顺序的分值
                }

                Db::startTrans();
                try {


                    print_r($params);

                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();


                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    public function getallquestion(){

        $question_obj = Db::name('KaoshiQuestions');
        $list = $question_obj->select();
        $list = collection($list)->toArray();
        $result = array("rows" => $list, "typelist" => ["1" => "单选题", "2" => "多选题", "3" => "判断题",]);

        return json($result);
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                $result = false;
                $question_obj = new \app\admin\model\kaoshi\examination\KaoshiQuestions;
                $LevelList = $question_obj->getLevelList();
                $typenum = [];
                foreach ($LevelList as $key => $value) {
                    $typenum[$key] = Db::name('KaoshiQuestions')
                        ->where(['deletetime' => NULL, 'subject_id' => $params['subject_id'], 'level' => $key, 'status' => 1])
                        ->group('type')
                        ->column(['type', 'count(id)' => 'num']);
                }


                $params['score'] = 0;
                $settingdata = json_decode($params['settingdata'], true);
                if (count($settingdata) < 1) {
                    $this->error('请添加考卷设置');

                }
                foreach ($settingdata as $key => $value) {
                    $num = intval($value['number']);
                    $mark = intval($value['mark']);
                    if (intval($value['number']) <= 0) {
                        $this->error('考卷设置第' . ($key + 1) . '项数量需大于0');
                    }
                    if (intval($value['mark']) <= 0) {
                        $this->error('考卷设置第' . ($key + 1) . '项分值需大于0');
                    }
                    if (is_array($typenum[$value['level']])) {
                        if (count($typenum[$value['level']]) == 0) {
                            $this->error('考卷设置第' . ($key + 1) . '项，该科目无[' . $LevelList[$value['level']] . ']级别题目');
                        }
                        if (!isset($typenum[$value['level']][$value['type']])) {
                            $this->error('考卷设置第' . ($key + 1) . '项，[' . $LevelList[$value['level']] . ']级别题目没有该题型');
                        } elseif ($typenum[$value['level']][$value['type']] < $value['number']) {
                            $this->error('考卷设置第' . ($key + 1) . '项数量过多[题库仅' . $typenum[$value['level']][$value['type']] . '题]');
                        }
                    }

                    $params['score'] += $num * $mark;

                }
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function getquestion($ids = null)
    {
        $row = $this->model->get($ids);
        $questionsdata  = $row['questionsdata'];
        $questionsdata  = rtrim($questionsdata, ',');
        if($questionsdata==''){
            $questionsdata = '0';
        }
        $settingdata = json_decode($row['settingdata'], true);

        

        $this->view->assign("row", $row);
        $questions = [];
        $question_obj = Db::name('KaoshiQuestions');
        

        $where["id"]=["in",$questionsdata];

        $questions = $question_obj
        ->where($where)
        ->select();

        $list = collection($questions)->toArray();
        

        /**********
        foreach ($settingdata as $key => $value) {
            $map['type'] = $value['type'];
            $map['subject_id'] = $row['subject_id'];
            $map['level'] = $value['level'];
            $map['status'] = 1;
            $map['deletetime'] = null;
            $arr = $question_obj->where($map)->select();

            $rand_arr = array_rand($arr, intval($value['number']));
            if (is_array($rand_arr)) {
                foreach ($rand_arr as $k => $v) {
                    $arr[$v]['selectdata'] = json_decode($arr[$v]['selectdata'], true);
                    if ($value['type'] == 2) {
                        $arr[$v]['answer'] = explode(',', $arr[$v]['answer']);
                    }
                    $questions[$key][$k] = $arr[$v];
                }

                shuffle($questions[$key]);
            } else {
                $arr[$rand_arr]['selectdata'] = json_decode($arr[$rand_arr]['selectdata'], true);
                if ($value['type'] == 2) {
                    $arr[$rand_arr]['answer'] = explode(',', $arr[$rand_arr]['answer']);

                }
                $questions[$key][] = $arr[$rand_arr];
            }

        } */
        // halt($questions);
        $this->view->assign("typeList", ["1" => "单选题", "2" => "多选题", "3" => "判断题",]);

        $this->view->assign("questions", $list);

        return $this->view->fetch();


    }


}
