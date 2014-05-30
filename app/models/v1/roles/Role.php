<?php
namespace StudyBranch\API\v1;
/**
 * A role is a set of permission given to users.
 * Traditional roles would be admins, users, and guests.
 */


class Role extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organization__role';
    protected $primaryKey = "role_id";

    public function users(){
        return $this->belongsToMany('StudyBranch\API\v1\User',"organization__role_user");
    }

    public function permissions(){
        return $this->belongsToMany('StudyBranch\API\v1\Permission',"organization__role_permission");
    }




}
