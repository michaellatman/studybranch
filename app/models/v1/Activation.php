<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/13/14
 * Time: 10:49 AM
 */

namespace StudyBranch\API\v1;
/**
 * Class Activation
 * @package Models
 * @subpackage User
 * @property int $code_id
 * @property string $code
 * @property int $user_id
 */

class Activation extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'user__activation_codes';
    protected $primaryKey = "code_id";
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('StudyBranch\API\v1\User');
    }
    //TODO: Create before save ::needshash



}