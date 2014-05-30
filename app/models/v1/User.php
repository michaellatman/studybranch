<?php
namespace StudyBranch\API\v1;


/**
 * Represents all users in the entire StudyBranch System
 * @package Models
 * @subpackage User
 * @property Credential $credential Credential object.
 * @property Phone $phone object
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property string $bio Bio
 * @property int $user_id User's ID
 * @property string $birthdate Birth-date
 * @property string $created_at Creation date
 * @property string $updated_at Last update Date
 */
class User extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';
	protected $primaryKey = "user_id";
 	public function credential()
    {
        return $this->hasOne('StudyBranch\API\v1\Credential');
    }
    public function activation()
    {
        return $this->hasMany('StudyBranch\API\v1\Activation');
    }
    public function groups()
    {
        return $this->belongsToMany('StudyBranch\API\v1\Group','group__user');
    }
    public function tokens()
    {
        return $this->hasMany('StudyBranch\API\v1\Token');
    }
    public function tasks()
    {
        return $this->hasMany('StudyBranch\API\v1\Task');
    }
    public function roles()
    {
        return $this->belongsToMany('StudyBranch\API\v1\Role','organization__role_user');
    }
    public function organizations()
    {
        return $this->belongsToMany('StudyBranch\API\v1\Organization','organization__user');
    }
    public function sections()
    {
        return $this->belongsToMany('StudyBranch\API\v1\Section','section__user');
    }
    public function tracks()
    {
        return $this->belongsToMany('StudyBranch\API\v1\Track','track__user');
    }
    public function hasPerm($org, $permid){
        if($org instanceof Organization) $org_id = $org->organization_id;
        else $org_id = $org;
        //SELECT * FROM `organization__role` join organization__role_user join organization__role_permission where user_id=1 and permission_id=2 and organization_id=1 LIMIT 1
        $perm = Role::join("organization__role_user","organization__role.role_id","=","organization__role_user.role_id")->join("organization__role_permission","organization__role_permission.role_id","=","organization__role_user.role_id")
            ->where("user_id","=",$this->user_id)->where("permission_id","=",$permid)->orWhere("permission_id","=",1)->where("organization_id","=",$org_id)->first();
        if($perm==null)
            return false;
        return true;
    }

    /**
     * Helper to get user phone object.
     *
     */
    public function phone(){
        return $this->hasOne('StudyBranch\API\v1\Phone');
    }
    /**
     * Helper to get user email addresses.
     *
     */
    public function emails(){
        return $this->hasMany('StudyBranch\API\v1\UserEmail');
    }
    /**
     * Helper to get user social logins.
     *
     */
    public function socials(){
        return $this->hasMany('StudyBranch\API\v1\SocialToken');
    }
    /**
     * Get's the user's bio.
     * @return string user's bio
     */
    public function getBio(){
        return $this->bio;
    }

    /**
     * Set's the user's bio.
     * @param (string) string bio of the user.
     */
    public function setBio($bio){
        $this->bio = $bio;
    }

    /**
     * Set's the user's phone number
     * @param (string) phone is the phone number to be set
     */
    public function setPhone($phone_number){
        $phone = $this->phone;
        if($phone == null){
           $phone = new Phone();
           $phone->user_id = $this->user_id;
           $phone->phone_number = $phone_number;
           $phone->save();
        }
        $phone->phone_number = $phone_number;


    }
}
