<?php
namespace StudyBranch\API\v1;

/**
 * @package Models
 */
class Task extends \Eloquent  {

    /**
     *
     *
     */
    protected $table = 'task';
    protected $primaryKey = "task_id";
    public function user()
    {
        return $this->belongsTo('StudyBranch\API\v1\user');
    }
    public function scopeCompleted($query)
    {
        return $query->where("completed","=",true);
    }
    public function scopeNotCompleted($query)
    {
        return $query->where("completed","=",false);
    }
}
