<?php
namespace StudyBranch\API\v1;
use api;
use GoogleApiClient;
use Illuminate\Support\Facades\Response;

/**
 * Class UserController
 * @package Controllers
 * @subpackage User
 */
class UserController extends \Controller{
    /**
     * Test
     */
    public function test()
    {
        /** @var SocialToken $token */
        $token = Auth::user()->socials()->first();
        $client = GoogleApiClient::getClient();

        $client->setAccessToken($token->social_token);
        $c = new \Google_Service_Oauth2($client);
        return "<img src=\"".$c->userinfo->get()->getPicture()."\"></img>";
    }
    /**
     * Function allows a user to add an email to their account.
     */
    public function post_add_email(){
        $validator = \Validator::make(
            array(
                'email' => \Input::get("email"),
            ),
            array(
                'email' => 'required|email|unique:user__email'
            )
        );
        if($validator->fails()){
            return \Response::json(array("errors"=>$validator->errors()->all()),400);
        }
        return $this->helper_send_add_email(Auth::user(),\Input::get("email"));
    }


    public function helper_send_add_email($user,$email){
        $act = new Activation(); #creates a new activation class
        $act->code = bin2hex(openssl_random_pseudo_bytes(16));
        $act->email =$email;
        $user->activation()->save($act);

        \Mail::send('emails.add_new', array("first_name"=>$user->first_name, 'token'=>$act->code), function($message) use ($user){
            $message->to(\Input::get("email"), $user->first_name)->subject('Confirm Email');
        });

    }

    /**
     * Function allows a user to add verify an email
     */
    public function get_email_verify($code){
        $activation = Activation::where("code","=",$code)->first();
        if($activation==null) return "No verification code!";
        $validator = \Validator::make(
            array(
                'email' => $activation->email,
            ),
            array(
                'email' => 'required|email|unique:user__email'
            )
        );
        if($validator->fails()){
            return \Response::json(array("errors"=>$validator->errors()->all()),400);
        }


        $user = $activation->user;

        $email = new UserEmail();
        if($user->emails()->where("primary","=",true)->count() == 0 )$email->primary = true;
        $email->email = $activation->email;
        $user->emails()->save($email);
        $activation->delete();
        return "Added!";

    }

    /**
     * Handles registration with validation.
     * @return User profile or errors
     */

    public function post_register(){ #registers new users
        $validator = \Validator::make( #validates inputted credentials
            array(
                "first_name" => \Input::get("first_name"),
                "last_name" => \Input::get("last_name"),
                "birthdate" => \Input::get("birthdate"),
                "username" => \Input::get("username"),
                "password" => \Input::get("password"),
                "email" => \Input::get('email')
            ),
            array(
                "first_name" => 'required',
                "last_name" => 'required',
                "birthdate" => 'date|required',
                "username" => 'required|unique:user__credential,username',
                "password" => 'min:5|required',
                "email" => 'required|email|unique:user__credential,email|unique:user__email'
            )
        );
        if ($validator->fails()){ #if the credentials are not filled in correctly, throws an error
            $failed = $validator->failed();
            return \Response::JSON(array('errors' => $failed), 400); #returns the errors
        }
        return \DB::transaction(function()
        {
            $user = new User(); #creates the new user classes
            $user->first_name = \Input::get("first_name");
            $user->last_name = \Input::get("last_name");
            $user->birthdate = \Input::get("birthdate");
            $user->save();  #saves user in database
            $user_credential = new Credential(); #creates the new user__credential class that links to the user class
            $user_credential->password = \Hash::make(\Input::get("password"));
            $user_credential->username = \Input::get("username");
            $user->credential()->save($user_credential); #saves user_credential and links it to the user class
            Organization::find(1)->addUser($user); // Add to StudyBranch organization.
            $this->helper_send_add_email($user,\Input::get("email"));
            $user->token = TokenController::gentoken($user->user_id);
            return $user->toJSON(); #returns the user (not the login credentials)
        });
    }



    /**
     * @return \Response user profile
     */
    public function get_account_info(){
        $user = Auth::user();
        $user->load("credential","roles.permissions");
        return \Response::json($user);
    }
    public function get_link_google(){
        $client = \GoogleApiClient::getClient();

        return \Redirect::to($client->createAuthUrl());


    }
    public function get_link_google_callback(){

        $client = \GoogleApiClient::getClient();
        if(\Input::has("code")){

            $client->authenticate($_GET['code']);
            $profile = new \Google_Service_Oauth2($client);



            $token = SocialToken::where("account_id","=",  $profile->userinfo->get()->getId())->first();
            if($token == null) $token = new SocialToken();
            else if($token->user_id != Auth::user()->user_id){
                return "This google account is already being used by another account";
            }
            $token->user_id = Auth::user()->user_id;
            $token->social_type = "google";
            $token->account_id = $profile->userinfo->get()->getId();
            $token->social_token = $client->getAccessToken();
            $decode = json_decode($client->getAccessToken());
            if(isset($decode->refresh_token)) $token->social_refresh = $decode->refresh_token;
            $token->save();
            return "";

        }
        else{
            return "Hmm no code..";
        }


    }

    /**
     * Handles changing a user's password..
     * POST account/change_password
     * @return \Response user profile
     */
    public function post_change_password(){
        //Check if they gave us and old password if not return error
        if(!\Input::has("old_password")){
            return \Response::json(array("message"=>"You must include an old password!"),400);
        }
        //Check if they gave us a new password if not return error
        if(!\Input::has("new_password")){
            return \Response::json(array("message"=>"You must include a new password!"),400);
        }
        //Get credentails of our current users
        $creds = Auth::user()->credential;
        //Check if password matches, if not return error.
        if(!\Hash::check(\Input::get("old_password"),$creds->password)){
            return \Response::json(array("message"=>"Old password was incorrect"),400);
        }
        //Does password match validation?

        $validator = \Validator::make(
            array(
                "password" => \Input::get("new_password")
            ),
            array(
                "password" => 'min:5|required'
            )
        );
        if($validator->fails()){
            return \Response::json(array("type"=>"validation","message"=>"Password does not meet requirements","errors"=>$validator->failed()),400);
        }
        $creds->password = \Hash::make(\Input::get("new_password"));
        $creds->save();
        Auth::user()->tokens()->delete();
        return \Response::json(array("message"=>"Password changed"));
    }

    /**
     * Change phone number
     * @return \Response User profile.
     */
    public function post_phone(){
        $user = Auth::user();
        $user->setPhone(\Input::get('phone'));
        $user->push();
        return $this->get_account_info();
    }

    /**
     * Change bio
     * @return \Response User profile.
     */
    public function post_change_bio(){
        $user = Auth::user();
        if(!\Input::has("new_bio")) return \Response::json(array("message"=>"new_bio required."));
        $user->bio = \Input::get("new_bio");
        $user->save();
        return $this->get_account_info();
    }

    /**
     * Change User Email
     * @return \Response User profile.
     */
    public function post_change_email(){
        $user = Auth::user();
        //if(!\Input::has("new_email")) return \Response::json(array("message"=>"New_email required."));
        $validator = \Validator::make(
            array('email' => \Input::get("new_email")),
            array('email' => 'required|email|unique:user__credential')
        );
        if ($validator->fails())
        {
            $failed = $validator->messages();
            return \Response::json($failed);
        }
        $user->activated = false;
        $user->credential->email = \Input::get("new_email");
        $user->push();
        Auth::user()->activation()->delete();
        $this->send_activation_email($user);
        return $this->get_account_info();
    }

    /**
     * Get phone number in JSON
     * @return \Response phone as JSON
     */
    public function get_account_phone(){
        $user = Auth::user();

        return \Response::json($user->phone);
    }

}