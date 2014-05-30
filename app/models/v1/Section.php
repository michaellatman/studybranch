<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/27/14
 * Time: 11:17 AM
 */

namespace StudyBranch\API\v1;


class Section extends \Eloquent{
    protected $table = 'section';
    protected $primaryKey = "section_id";

    public function users(){
        return $this->belongsToMany('StudyBranch\API\v1\User',"section__user");
    }
    public function admins(){
        return $this->belongsToMany('StudyBranch\API\v1\User',"section__admin");
    }
    public function hasAdmin($user_id){
        $query = $this->admins()->where("section__admin.user_id","=",$user_id)->count();
        return $query>0;
    }
    public function assignments(){
        return $this->belongsToMany('StudyBranch\API\v1\Assignment',"assignment__section")->select("assignment__section.section_id as section_id");
    }
} 