<?php
namespace StudyBranch\API\v1;

/**
 * Holds every user's phone number
 * @package Models
 * @subpackage User
 * @property string $phone_number the actual phone number
 * @property int $user_id the attached user ID
 * @property User $user the actual user object.
 */
class Phone extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user__phone';

    /**
     * The primary key in the database
     * @var string
     */
    protected $primaryKey = "phone_id";
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('StudyBranch\API\v1\User');
    }



}