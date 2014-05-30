<?php
namespace StudyBranch\API\v1;
/**
 * Organization is the top level of StudyBranch. Each Organization has users, sections, and roles.
 *
 */


class Group extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'group';
    protected $primaryKey = "group_id";

    public function users(){
        return $this->belongsToMany('StudyBranch\API\v1\User',"group__user");
    }
    public function getPublicUsers(){
        return \DB::table('group__user')->where("group_id","=",$this->group_id)->join("user","group__user.user_id","=","user.user_id")->select('user.user_id', 'first_name','last_name');
    }
    public function organization(){
        return $this->belongsTo('StudyBranch\API\v1\Organization');
    }
    public function announcements(){
        return $this->morphMany('StudyBranch\API\v1\Announcement',"shoutable");
    }
}
