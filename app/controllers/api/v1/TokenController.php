<?php
namespace StudyBranch\API\v1;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class TokenController
 * @package Authentication
 */
class TokenController extends \Controller {


    /**
     * Authenticates a user using a username/email and password.
     * Returns JSON response with access_key
     * @return \Illuminate\Http\JsonResponse Returns JSON response with access_key
     */
    public function get()
    {

        if(!\Input::has("username")||!\Input::has("password")){
            return \Response::JSON(array('message'=>"Account information missing."),400);
        }

        $account = Credential::Where("username","=",\Input::get("username"))->first();
        if($account == null){
            $em = UserEmail::Where("email","=",\Input::get("username"))->first();
            if($em != null){
                $account=$em->user->credential;
            }
        }

        if($account==null){
            return \Response::JSON(array('message'=>"Username/password is incorrect."),401);
        }
        if(\Hash::check(\Input::get("password"),$account->password)){

            return \Response::JSON($this->gentoken($account->user_id));
        }
        else{
            return \Response::JSON(array('message'=>"Username/password is incorrect."),401);
        }
    }
    public function login_with_google(){
        $client = \GoogleApiClient::getClient();
        $client->setRedirectUri(url("/api/v1/login/google/callback"));
        return \Redirect::to($client->createAuthUrl());
    }
    public function login_with_google_callback(){
        $client = \GoogleApiClient::getClient();
        if(\Input::has("code")){
            $client->setRedirectUri("postmessage");
            $client->authenticate($_GET['code']);
            $profile = new \Google_Service_Oauth2($client);



            $token = SocialToken::where("account_id","=",  $profile->userinfo->get()->getId())->first();
            if($token == null){
                return \Response::json(array("message"=>"This google account is not linked to an account!",400));
            }
            $user = $token->user;
            return $this->gentoken($user->user_id);

        }
        else{
            return "Hmm no code..";
        }

    }
    public static function gentoken($userid){
        $bytes = bin2hex(openssl_random_pseudo_bytes(10));
        $myToken = new Token;
        $myToken->user_id=$userid;
        $myToken->access_key = $bytes;
        $myToken->expire_at = date("Y-m-d H:i:s", strtotime('+5 hours'));
        $secret = "124oSIFgXwa4wU2k5q04RO0WiFtIx5iTuxyF2xZq";
        $tokenGen = new \Services_FirebaseTokenGenerator($secret);
        $ftoken = $tokenGen->createToken(array("user_id" => $userid));
        $myToken->save();
        return array("access_key"=>$bytes, "expires"=>$myToken->expire_at, "firebase"=>$ftoken);
    }

    public static $myUser = null;

    /**
     * Check's the provided credentials. Returns null if success, string if invalid.
     * @return null|string Errors.
     */
    public static function check()
    {
        $input = null;
        if(\Input::get('state')) $input = \Input::get('state'); //For google auth
        if(\Input::get('access_key')) $input = \Input::get('access_key');
        if(\Request::header('Authorization')) $input = \Request::header('Authorization');
        if(isset($_SERVER['PHP_AUTH_USER'])) $input = $_SERVER['PHP_AUTH_USER'];
        $myToken = Token::where("access_key","=",$input)->first();

        if(!$myToken) return false;
        TokenController::$myUser = User::find($myToken->user_id)->load("organizations");
        return true;
    }

    /**
     * Get the current user for this request.
     * @return User authenticated user
     */
    public static function user()
    {
        return TokenController::$myUser;
    }





}
