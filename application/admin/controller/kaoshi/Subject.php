<?php

namespace app\admin\controller\kaoshi;

use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Subject extends Backend
{

    /**
     * Subject模型对象
     * @var \app\admin\model\KaoshiSubject
     */
    protected $model = null;
	
	//protected $parents = [];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\kaoshi\KaoshiSubject;

		
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
		$this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $list = $this->model
				->with(['pid'])
                ->where($where)
                ->order($sort, $order)
                ->paginate($limit);
				
		
		
            $result = array(
			"total" => $list->total(), 
			"rows" => $list->items(),
			"parent" => []
			);

            return json($result);
        }
        return $this->view->fetch();
    }


    public function getSubTree()
    {
		$this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->paginate($limit);
				
		
            $arrs = array();
            //调用函数recur
            $arrs = $this->recur($arrs,$list);

            return json($arrs);
        }
        return $this->view->fetch();
    }
    //定义函数递归调用获得需要的结构的数组
    public function  recur ($arrs,$data,$pid=0) {

        foreach ($data as $k => $v){
            if($v['pid'] == $pid){
                $arr = array('name' => $v["subject_name"],'id'=>$v['id'],'children'=>array());
                $arr['children'] = $this->recur($arr["children"],$data,$v['id']);

                array_push($arrs,$arr);
            }
        }
        return $arrs;
    }

    

}
