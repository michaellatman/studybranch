<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/13/14
 * Time: 10:49 AM
 */

namespace StudyBranch\API\v1;
/**
 * Class SocialToken
 * @package Models
 */

class SocialToken extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'user__social';
    protected $primaryKey = "social_id";
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('StudyBranch\API\v1\User');
    }
}