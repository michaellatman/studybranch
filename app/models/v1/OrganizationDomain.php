<?php
namespace StudyBranch\API\v1;

/**
 * Holds every user's emails
 * @package Models
 */
class OrganizationDomain extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organization__domain';

    /**
     * The primary key in the database
     * @var string
     */
    protected $primaryKey = "domain_id";
    public $timestamps = false;
    public function organization()
    {
        return $this->belongsTo('StudyBranch\API\v1\Organization');
    }



}