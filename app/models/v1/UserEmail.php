<?php
namespace StudyBranch\API\v1;

/**
 * Holds every user's emails
 * @package Models
 */
class UserEmail extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user__email';

    /**
     * The primary key in the database
     * @var string
     */
    protected $primaryKey = "email_id";
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo('StudyBranch\API\v1\User');
    }



}