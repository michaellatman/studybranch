<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/27/14
 * Time: 9:45 AM
 */

namespace StudyBranch\API\v1;


use Illuminate\Support\Facades\Input;

class AssignmentController extends \Controller{
    public function __construct()
    {
        $this->beforeFilter('cred', array('except' => 'getLogin'));

        //$this->beforeFilter('csrf', array('on' => 'post'));

        //$this->afterFilter('log', array('only' =>
        //    array('fooAction', 'barAction')));
    }


    public function index(){
        $user = Auth::user();
        $sections = $user->sections()->with('assignments')->get();
        $assignments = [];
        for($i=0;$i<count($sections);$i++){
            for($a  = 0;$a<count($sections[$i]->assignments);$a++) {
                $asnm = $sections[$i]->assignments[$a];
                $assignments[] = $asnm->toArray();
            }
        }
        $sections = $user->sections->toArray();


        return \Response::json(compact("assignments","sections"));
    }
    public function show($id){
        $section_assignment = \DB::table("assignment__section")->where("assignment_id","=",$id)->first();
        if($section_assignment!=null){
            if(!Auth::user()->sections->contains($section_assignment->section_id)){
                return \Response::json(array("message"=>"Can't access!"),400);
            }
            $assignment = Assignment::find($id);
            $assignment->section_id = $section_assignment->section_id;
            $assignment=$assignment->toArray();
            return \Response::json(compact("assignment"));
        }
        $track_assignment = \DB::table("assignment__track")->where("assignment_id","=",$id)->first();
        if($track_assignment!=null){
            if(!Auth::user()->track->contains($track_assignment->track_id)){
                return \Response::json(array("message"=>"Can't access!"),400);
            }
            $assignment = Assignment::find($id);
            $assignment->track_id = $track_assignment->track_id;
            $assignment=$assignment->toArray();
            return \Response::json(compact("assignment"));

        }
    }

    public function store(){
        $validator = \Validator::make( #validates inputted credentials
            array(
                'title' => \Input::get('assignment.title'),
                'body' => \Input::get('assignment.body')
            ),
            array(
                'title' => 'required',
                'body' => ''
            )
        );
        if ($validator->fails()){
            $failed = $validator->failed();
            return \Response::JSON(array('errors' => $failed), 400); #returns the errors
        }
        $assignment = new Assignment();
        $assignment->title = Input::get("assignment.title");
        $assignment->body = Input::get("assignment.body","");
        if(\Input::has("assignment.track")){
            //User is saving an assignment to a track.. Let's handle that now.
            $track = Track::find(\Input::get("assignment.track"));
            if($track==null) return \Response::json(array("message"=>"No track found"),404);
            if(!$track->hasAdmin(Auth::user()->user_id)){
                return \Response::json(array("message"=>"Can't add assignment to a track that you can't modify!"),400);
            }
            $assignment->save();
            $track->assignments()->attach($assignment);
            $assignment=$assignment->toArray();
            $assignment['track_id'] = $track->track_id;
            $track=$track->toArray();
            return \Response::json(compact("assignment","track"));
        }
        else if(\Input::has("assignment.section")){
            //User is saving an assignment to a track.. Let's handle that now.
            $section = Section::find(\Input::get("assignment.section"));
            if($section==null) return \Response::json(array("message"=>"No section found"),404);
            if(!$section->hasAdmin(Auth::user()->user_id)){
                return \Response::json(array("message"=>"Can't add assignment to a sections that you can't modify!"),400);
            }
            $assignment->save();
            $section->assignments()->attach($assignment);

            $assignment=$assignment->toArray();
            $assignment['section_id'] = $section->section_id;
            $section=$section->toArray();
            return \Response::json(compact("assignment","section"));
        }
    }

    public function update(){

    }

    public function destroy(){

    }
} 