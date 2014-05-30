<?php
namespace StudyBranch\API\v1;
/**
 * Organization
 * is the top level of StudyBranch. Each Organization has users, sections, and roles.
 *
 */


/**
 * Class Organization
 * @property string name
 * @property mixed users
 * @package StudyBranch\API\v1
 */
class Organization extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organization';
    /**
     * @var string
     */
    protected $primaryKey = "organization_id";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany('StudyBranch\API\v1\User',"organization__user");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function announcements(){
        return $this->morphMany('StudyBranch\API\v1\Announcement',"shoutable");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles(){
        return $this->hasMany('StudyBranch\API\v1\Role');
    }
    public function tracks(){
        return $this->hasMany('StudyBranch\API\v1\Track');
    }


    /**
     * Generates and attaches the three default roles to the organization.
     * Also adds the user as admin.
     * @param $user
     */
    public function generateDefaultRolesWithAdmin($user){
        $org = $this;
        $everyone = new Role();
        $everyone->name = "Everyone";
        $everyone->default = true;
        $everyone->description = ""; //TODO: Write descriptions for roles.
        $org->roles()->save($everyone);
        $teacher = new Role();
        $teacher->name = "Teacher";
        $teacher->default = false;
        $teacher->description = ""; //TODO: Write descriptions for roles.
        $org->roles()->save($teacher);
        $teacher->permissions()->attach(array(3,4));
        $teacher->push();
        $admin = new Role();
        $admin->name = "Admin";
        $admin->default = false;
        $admin->description = ""; //TODO: Write descriptions for roles.
        $org->roles()->save($admin);
        $admin->permissions()->attach(1);
        $org->addUser($user);
        $org->giveRole(Auth::user(),$admin->role_id);
    }

    /**
     * Add's user to the organization
     * @param User $user
     * @return boolean true if added, false if not.
     */
    public function addUser($user){
        return \DB::transaction(function() use ($user)
        {

            $default_roles = $this->roles()->where("default","=",true)->get();
            if($default_roles->count()==0){
                return false;
            }
            if($user->organizations->contains($this->organization_id)){
                return false;
            }

            $user->organizations()->attach($this);
            $array = array();
            for($i=0;$i<count($default_roles);$i++){
                $array[$i] = $default_roles[$i]->role_id;
            }
            $user->roles()->attach($array);

            \DB::commit();
            return true;
        });
    }

    /**
     * Gives a user a role
     * @param User $user
     * @param Integer $roleid
     * @return boolean
     */
    public function giveRole($user,$roleid){
        return \DB::transaction(function() use ($user,$roleid)
        {

            $role = $this->roles()->where("role_id","=",$roleid)->get();
            if($role==null){
                return false;
            }
            $user->roles()->attach($roleid);

            \DB::commit();
            return true;
        });
    }

    /**
     * Removes a given user from the organization
     * @param User $user
     * @return mixed
     */
    public function removeUser($user){
        return \DB::transaction(function() use ($user)
        {
            $roles = Role::where("organization_id","=",$this->organization_id)->get();
            foreach($roles as $role){
                $role->users()->detach($user->user_id);
                $role->push();
            }
            $this->users()->detach($user->user_id);


            \DB::commit();
            return true;
        });
    }
}
