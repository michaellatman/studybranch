<?php
namespace StudyBranch\API\v1;
/**
 * TestController. Shows info for the current user.
 * @package Controllers
 * @subpackage User
 */
class TestController extends \Controller {


    /**
     * Uses the Auth object to get the users first name.
     * @return \View view with message
     */
    public function showInfo()
    {
        return \View::make('hello', array('message' => 'Hi '.Auth::user()->first_name.'! You are using API v1'));
    }


}
