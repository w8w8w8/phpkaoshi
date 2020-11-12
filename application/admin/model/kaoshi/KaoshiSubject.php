<?php

namespace app\admin\model\kaoshi;

use think\Model;
use traits\model\SoftDelete;

class KaoshiSubject extends Model
{

    use SoftDelete;


    // 表名
    protected $name = 'kaoshi_subject';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = 'deletetime';
	
    //protected $pid = 'pid';
    //protected $pidname = 'pidname';

    // 追加属性
    protected $append = [


    ];
	
	public function pid(){
		return $this->belongsTo('app\admin\model\kaoshi\KaoshiSubject','pid', 'id')->setEagerlyType(0)->joinType('LEFT');
		 //return $this->hasOne('app\admin\model\kaoshi\KaoshiSubject', 'id', 'subject_id')->setEagerlyType(0)->joinType('LEFT');
	}


}
