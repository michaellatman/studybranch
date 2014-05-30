<?php
/**
 * Created by PhpStorm.
 * User: noahtodd
 * Date: 5/15/14
 * Time: 8:59 AM
 */

namespace StudyBranch\API\v1;


/**
 * Class AnnouncementController
 * @package StudyBranch\API\v1
 */
class AnnouncementController extends \Controller{
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
    public function GetAnnouncementsForIDS($type,$ids,$approved){
        $query = Announcement::where("shoutable_type", "=", $type)->approved($approved)->where(function($query) use($ids)
        {
            for ($i = 0; $i < count($ids); $i++) {

                $query->orWhere("shoutable_id", "=", $ids[$i]);
            }
        });
        return $query->orderBy("created_at","DESC")->get();
        //dd(\DB::getQueryLog());
    }

    public function index(){
        //Input contains a comma separated list of scopes.
        $response = [];
        $response_orgs = [];
        // They want specific organization
        $approved = \Input::get("approved",true);
        if(\Input::has("organizations")){
            $orgs = explode(',', \Input::get("organizations"));
            $actual_orgs = []; //Orgs the person is actually a part of.
            for($i=0;$i<count($orgs);$i++){
                if(Auth::user()->organizations->contains($orgs[$i])){
                    $actual_orgs[] = $orgs[$i];
                }
            }
            if(count($actual_orgs)>0) {
                $done = $this->GetAnnouncementsForIDS('StudyBranch\API\v1\Organization',$actual_orgs,$approved);
                $done = $done->toArray();
                for ($i = 0; $i < count($done); $i++) {
                    $response[] = $done[$i];
                }
            }
        }
        else{
            $orgs = Auth::user()->organizations;
            $actual_orgs = [];
            for($i=0;$i<count($orgs);$i++){
                    $actual_orgs[] = $orgs[$i]->organization_id;
            }
            if(count($actual_orgs)>0) {
                $done = $this->GetAnnouncementsForIDS('StudyBranch\API\v1\Organization',$actual_orgs,$approved);
                for ($i = 0; $i < count($done); $i++) {
                    $done[$i]->organization = $done[$i]->shoutable->organization_id;
                    $response_orgs[] = $done[$i]->shoutable->toArray();
                    $d = $done->toArray();
                    $response[] = $d[$i];
                }
            }
        }
        //DD(\DB::getQueryLog());
        return \Response::json(array("news"=>$response,"organizations"=>$response_orgs));
    }

    public function store(){
        if(\Input::has("news.organization")){
            //Saving to an org.
            if (!Auth::isInOrg(\Input::get('news.organization'))){
                return \Response::json(array('message'=>'You are not a part of this organization and cannot post announcements in it'), 403);
            }
            $validator = \Validator::make( #validates inputted credentials
                array(
                    'title' => \Input::get('news.title'),
                    'body' => \Input::get('news.body')
                ),
                array(
                    'title' => 'required',
                    'body' => '',
                )
            );
            if ($validator->fails()){ #if the credentials are not filled in correctly, throws an error
                $failed = $validator->failed();
                return \Response::JSON(array('errors' => $failed), 400); #returns the errors
            }
            $announcement = new Announcement();
            $announcement->title = \Input::get('news.title');
            $announcement->body = \Input::get('news.body');
            $user = Auth::user();
            $announcement->owner = $user->user_id;
            $organization = Organization::find(\Input::get('news.organization'));
            $announcement->approved = 0;
            if ($user->hasPerm($organization, 8)){
                $announcement->approved = 1;
            }
            $announcement = $organization->announcements()->save($announcement);
            return \Response::JSON($announcement);
        }
        else{
            return \Response::JSON(array("message"=>"News endpoint not yet implemented"),400);
        }
    }
} 