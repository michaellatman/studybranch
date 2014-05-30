<?php
namespace StudyBranch\API\v1;

/**
 * Class OrganizationController
 * Handles controlling information about organizations.
 * Uses JSON API Spec. http://jsonapi.org/
 * @package StudyBranch\API\v1
 */
class OrganizationController extends \Controller {

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('cred', array('except' => 'getLogin'));

        //$this->beforeFilter('csrf', array('on' => 'post'));

        //$this->afterFilter('log', array('only' =>
        //    array('fooAction', 'barAction')));
    }

    /**
     * List of Organization the user is a part of.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $user_orgs = Auth::user()->organizations()->get();
        return \Response::json(array("organizations"=>$user_orgs->toArray()));
    }

    /**
     * Show a specific organization
     * @param $id ID of the organization.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        if(Auth::user()->organizations()->get()->contains($id)){
            $org = Organization::find($id);
            $user_ar = $org->users;
            //Get list of ID's.
            $users_ids=[];
            for($i=0;$i<count($user_ar);$i++){
                $user_ids[$i] = $user_ar[$i]->user_id;
            }
            $org_array = $org->toArray();
            $org_array['users'] = $user_ids;

            return \Response::json(array("organization"=>$org_array,"users"=>$user_ar->toArray()));
        }
        return \Response::json(array("message"=>"User not in organization."),400);
    }

    /**
     * Create a new organization
     * Requires JSON like:
     * {
     *  "organization":{
     *      "name": "NAME HERE"
     *  }
     * }
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store()
    {
        $validator = \Validator::make(
            array(
                'name' => \Input::get("organization.name")
            ),
            array(
                'name' => 'required|unique:organization|between:5,20'
            )
        );
        if($validator->passes()){
            return \DB::transaction(function(){
                $org = new Organization();
                $org->name = \Input::get("organization.name");
                $org->save();
                $org->generateDefaultRolesWithAdmin(Auth::user());

                \DB::commit();
                return \Response::json(array("organization"=>$org->toArray(),"users"=>$org->users->toArray()));
            });


        }
        else{
            return \Response::json(array("errors"=>$validator->errors()->all()),400);
        }
    }

    /**
     * Modify the organization.
     * @param integer $id ID of the organization to be updated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id){
        if(Auth::user()->organizations()->get()->contains($id)){

            /** @var Organization $org */
            $org = Organization::find($id);
            if(!Auth::user()->hasPerm($org,21)){
                return \Response::json(array("errors"=>["You don't have permission to do that."]),400);
            }
            $validator = \Validator::make(
                array(
                    'name' => \Input::get("organization.name"),
                ),
                array(
                    'name' => 'required|unique:organization|between:5,20'
                )
            );
            if($validator->passes()){
                $org->name = \Input::get("organization.name");
                $org->save();
                return \Response::json(array("organization"=>$org->toArray()));
            }
            else{
                return \Response::json(array("errors"=>$validator->errors()->all()),400);
            }

        }
    }
}