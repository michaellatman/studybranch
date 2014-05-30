<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/19/14
 * Time: 12:45 PM
 */

namespace StudyBranch\API\v1;


class Track extends \Eloquent{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'track';
    protected $primaryKey = "track_id";

    public function users(){
        return $this->belongsToMany('StudyBranch\API\v1\User',"track__user");
    }
    public function admins(){
        return $this->belongsToMany('StudyBranch\API\v1\User',"track__admin");
    }
    public function hasUser($user_id){
        $query = $this->users()->where("track__user.user_id","=",$user_id)->count();
        return $query>0;
    }
    public function hasAdmin($user_id){
        $query = $this->admins()->where("track__admin.user_id","=",$user_id)->count();
        return $query>0;
    }

    public function assignments(){
        return $this->belongsToMany('StudyBranch\API\v1\Assignment',"assignment__track");
    }

} 