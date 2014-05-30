<?php
namespace StudyBranch\API\v1;

/**
 * Token is the method that most API's use to authenticate.
 * This modal has no real purpose other than connecting token-> user.
 * @package Models
 * @subpackage User
 * @property string $access_key
 * @property int $user_id ID of the user
 * @property User $user
 */
class Token extends \Eloquent  {

    /**
     *
     *
     */
    protected $table = 'user__token';
    protected $primaryKey = "token_id";
    public function user()
    {
        return $this->hasOne('StudyBranch\API\v1\user');
    }




}
