<?php
namespace StudyBranch\API\v1;
/**
 * Class GroupController
 * Handles controlling information about groups.
 * @package StudyBranch\API\v1
 */
class GroupController extends \Controller {


    public function get_group()
    {
        return \Response::json(Auth::group());

    }

    /**
     * Get list of users
     * HTTP get params:
     *  limit - The limit of users that the request will return (default 10)
     *  skip - the amount of users to skip (for pagination)
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_user_list()
    {
        $limit = \Input::get("limit",10);
        $skip = \Input::get("skip",0);
        $group = Auth::group();
        return \Response::json($group->getPublicUsers()->skip($skip)->take($limit)->get());
    }
}