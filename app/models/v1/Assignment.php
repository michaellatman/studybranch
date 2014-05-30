<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/15/14
 * Time: 9:19 AM
 */

namespace StudyBranch\API\v1;


class Assignment extends \Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assignment';
    protected $primaryKey = "assignment_id";

} 