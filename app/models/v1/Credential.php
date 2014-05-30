<?php
namespace StudyBranch\API\v1;
/**
 * Class Credential
 * @package Models
 * @subpackage User
 * @property string $password
 * @property string $username
 * @property string $email
 * @property int $user_id
 * @property User $user
 */

class Credential extends \Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'user__credential';
	protected $primaryKey = "credential_id";
    protected $hidden = array('credential_id','password');
	public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('StudyBranch\API\v1\User');
    }
    //TODO: Create before save ::needshash



}
