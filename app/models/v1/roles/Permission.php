<?php
namespace StudyBranch\API\v1;
/**
 * A permission is something given to users through roles.
 * Traditional permissions would be creating/modifying classes.
 *
 */


class Permission extends \Eloquent{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lookup__permissions';
    protected $primaryKey = "permission_id";






}
