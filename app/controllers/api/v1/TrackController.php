<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/19/14
 * Time: 12:44 PM
 */

namespace StudyBranch\API\v1;


class TrackController  extends \Controller{
   public function __construct()
   {
        $this->beforeFilter('cred', array('except' => 'getLogin'));
   }

    /**
     * Function to abstract query logic for getting all tracks.
     * @param integer $id
     * @return mixed|static
     */
    public function getTrack($id){
        $trackQuery = Track::leftJoin("track__admin","track.track_id","=","track__admin.track_id")
            ->leftJoin("track__user","track.track_id","=","track__user.track_id")
            ->where("track.track_id","=",$id)->Where("track__user.user_id","=",Auth::user()->user_id)
            ->select("track.name","track.track_id","track.organization_id as organization","track__user.track__user_id","track__admin.track__admin_id","track.description")->first();
        return $trackQuery;
    }

    /**
     * Index
     * Get all tracks that a user is a part of.
     */
    public function index(){
        $trackQuery = Track::leftJoin("track__user","track.track_id","=","track__user.track_id")->Where("track__user.user_id","=",Auth::user()->user_id)
            ->select("track.name","track.track_id","track.organization_id as organization","track__user.track__user_id","track.description");
        $tracks = $trackQuery->get()->toArray();
        return \Response::json(compact("tracks"));
   }

    /**
     * Show a specific track
     * @param $id Numeric track ID
     * @return \Illuminate\Http\JsonResponse JSON representation of the track.
     */
    public function show($id){
        $track = $this->getTrack($id);
        if(is_null($track)){
            return \Response::json(array("message"=>"Track not found."),404);
        }
        $track = $track->toArray();
        return \Response::json(compact("track"));
    }

    /**
     * Update a track with a given ID.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id){
        $track = $this->getTrack($id);
        if(is_null($track)){
            return \Response::json(array("message"=>"Track not found."),404);
        }
        if($track->track__admin_id == null){
            return \Response::json(array("message"=>"You are not allowed to modify this track"));
        }
        $validator = \Validator::make( #validates inputted credentials
            array(
                'name' => \Input::get('track.name'),
                'description' => \Input::get('track.description'),
                'public' => \Input::get('track.public')
            ),
            array(
                'name' => '',
                'description' => '',
                'public' => 'integer|max:2|min:0'
            )
        );
        if ($validator->fails()){ #if the credentials are not filled in correctly, throws an error
            $failed = $validator->failed();
            return \Response::JSON(array('errors' => $failed), 400); #returns the errors
        }
        if(\Input::get("track.name")!=$track->name) {
            if (Track::where("name", "=", \Input::get("track.name"))->where("organization_id", "=", $track->organization_id)->get()->count() > 0) {
                return \Response::json(array('message' => 'A track with that name already exists! Track names must be unique in each organization.'), 403);
            }
        }
        $track->name = \Input::get('track.name',$track->name);
        $track->description = \Input::get('track.description',$track->description);
        //$track->owner = $user->user_id;
        $track->public = \Input::get("track.public",$track->public);
        $track->save();
        $track=$track->toArray();
        return \Response::json(compact("track"));
    }

    /**
     * Create a new track. Must have a unique name.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(){
        if (!Auth::isInOrg(\Input::get('track.organization'))){
            return \Response::json(array('message'=>'You are not a part of this organization and cannot make tracks in it'), 403);
        }
        $organization = Organization::find(\Input::get('track.organization'));
        $user = Auth::user();
        if (!$user->hasPerm($organization, 3)){
            return \Response::json(array('message'=>'You cannot create tracks in this organization'), 403);
        }
        $validator = \Validator::make( #validates inputted credentials
            array(
                'name' => \Input::get('track.name'),
                'description' => \Input::get('track.description'),
                'public' => \Input::get('track.public')
            ),
            array(
                'name' => 'required',
                'description' => '',
                'public' => 'integer|max:2|min:0'
            )
        );
        if ($validator->fails()){ #if the credentials are not filled in correctly, throws an error
            $failed = $validator->failed();
            return \Response::JSON(array('errors' => $failed), 400); #returns the errors
        }
        if(Track::where("name","=",\Input::get("track.name"))->where("organization_id","=",$organization->organization_id)->get()->count()>0){
            return \Response::json(array('message'=>'A track with that name already exists! Track names must be unique in each organization.'), 403);
        }
        $track = new Track();
        $track->name = \Input::get('track.name');
        $track->description = \Input::get('track.description',"");
        //$track->owner = $user->user_id;
        $track->public = \Input::get("track.public",false);
        $track = $organization->tracks()->save($track);

        $track->admins()->attach($user);
        $track->users()->attach($user);
        return \Response::JSON($track);
    }

} 