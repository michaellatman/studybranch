<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/27/14
 * Time: 9:54 AM
 */

namespace StudyBranch\API\v1;


class SectionController extends \Controller{
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
     * List of Sections the user is a part of.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $section_user = Auth::user()->sections()->get();
        return \Response::json(array("sections"=>$section_user->toArray()));
    }

    /**
     * Show a specific section
     * @param $id ID of the section.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        if(Auth::user()->sections()->get()->contains($id)){
            $section = Section::find($id);
            $user_ar = $section->users;
            //Get list of ID's.
            $users_ids=[];
            for($i=0;$i<count($user_ar);$i++){
                $user_ids[$i] = $user_ar[$i]->user_id;
            }
            $section_array = $section->toArray();
            $section_array['users'] = $user_ids;

            return \Response::json(array("section"=>$section_array,"users"=>$user_ar->toArray()));
        }
        return \Response::json(array("message"=>"You are not in this section"),400);
    }

    /**
     * Create a new section
     * Requires JSON like:
     * {
     *  "section":{
     *      "name": "NAME HERE",
     *      "organization": "ORGANIZATION NAME HERE"
     *  }
     * }
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store()
    {
        if(!Auth::isInOrg(\Input::get('section.organization'))){
            return \Response::json(array('message'=>'You are not a part of this organization and cannot create sections in it'), 403);
        }
        if (!(Auth::user()->hasPerm(\Input::get("section.organization"), 3))){
            return \Response::json(array('message'=>'You do not have permission to create sections in this organization'), 403);
        }
        $validator = \Validator::make(
            array(
                'name' => \Input::get("section.name"),
                'organization' => \Input::get("section.organization")
            ),
            array(
                'name' => 'required|unique:section',
                'organization' => 'exists:organization,organization_id'
            )
        );
        if($validator->passes()){
            return \DB::transaction(function(){
                $section = new Section();
                $section->name = \Input::get("section.name");
                $section->organization_id = \Input::get("section.organization");
                $section->save();
                /*$section__user = new*/
                \DB::commit();
                $user = Auth::user();
                $section->admins()->attach($user);
                $section->users()->attach($user);
                return \Response::json(array("section"=>$section->toArray(),"users"=>$section->users->toArray()));
            });
        }
        else {
            return \Response::json(array("errors"=>$validator->errors()->all()),400);
        }
    }

    /**
     * Modify the section.
     * @param integer $id ID of the section to be updated.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id){
        /*if(Auth::user()->organizations()->get()->contains($id)){

            /** @var Organization $org */
            /*$org = Organization::find($id);
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

        }*/
    }
} 