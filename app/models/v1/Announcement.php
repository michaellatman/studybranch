<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/15/14
 * Time: 9:19 AM
 */

namespace StudyBranch\API\v1;


class Announcement extends \Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'announcement';
    protected $primaryKey = "announcement_id";
    public function shoutable()
    {
        return $this->morphTo();
    }
    public function scopeApproved($query, $bool = true){
        return $query->where("approved","=",$bool);
    }
    public function user()
    {
        return $this->hasOne('StudyBranch\API\v1\User', 'user');
    }
} 