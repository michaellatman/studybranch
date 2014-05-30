<?php
namespace StudyBranch\API\v1;


/**
 * Used to get the current user object.
 * @package Authentication
 */
class Auth {
    /**
     * Returns the currently authenticated user. Just a helper function.
     * @return User authenticated user object
     */
    public static function user()
    {
        return TokenController::user();
    }
    public static function organization(){
        return Auth::$group;
    }
    public static function group(){
        return Auth::$group;
    }
    public static function isInOrg($id){
        if(Auth::user()->organizations->contains($id)){
            return true;
        }
        return false;
    }
    public static function isInGroup($id){
        if(Auth::user()->groups->contains($id)&&Auth::isInOrg(Group::find($id)->organization->organization_id)){
            return true;
        }
        return false;
    }
    static private $organization = null;
    static private $group = null;
    public static function setOrganization($org){
        Auth::$organization = $org;
    }
    public static function setGroup($group){
        Auth::$group = $group;
    }

}