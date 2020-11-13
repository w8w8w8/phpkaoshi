<?php

namespace addons\kaoshi\model\examination;
use think\Model;
use traits\model\SoftDelete;

class KaoshiUserLearn extends Model
{

    

    

    // 表名
    protected $name = 'kaoshi_user_learn';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'learn_time_text'
    ];
    

    



    public function getLearnTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['learn_time']) ? $data['learn_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setLearnTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
