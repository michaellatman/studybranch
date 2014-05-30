<?php
class GoogleApiClient {
    public static function getClient(){
        $client = new \Google_Client();
        $client->setClientId(\Config::get('api.google_client_id'));
        $client->setClientSecret(\Config::get('api.google_client_secret'));
        $client->setDeveloperKey(\Config::get('api.google_client_developer_key'));
        $client->addScope(\Google_Service_Plus::PLUS_LOGIN);
        $client->addScope(\Google_Service_Plus::USERINFO_EMAIL);
        $client->addScope(\Google_Service_Drive::DRIVE);
        $client->setAccessType('offline');
        $client->setRedirectUri(url('/api/v1/account/link/google/callback'));
        $client->setState(\Input::get("access_key"));
        return $client;
    }
}