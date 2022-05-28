<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

global $db, $crud;
use Google_Client;
use Support\Input\Input;
use Support\Users\Auth;

$input = new Input();

$auth = new Auth('SP_token', false, false);

//Get google token from $_POST
$id_token = $input->req()->post('google_token')->value;
$client_id = 'GOOGLE_ID_TOKEN';

$client = new Google_Client(['client_id' => $client_id]);

//Check if google token is valid and get user info
$payload = $client->verifyIdToken($id_token);

if($payload){
    $data = 
    [
        'id_extern' => $payload['sub'],
        'nume'      => $payload['name'],
        'email'     => $payload['email'],
        'browser'   => $_SERVER['HTTP_USER_AGENT'],
        'os'        => $_SERVER['HTTP_SEC_CH_UA_PLATFORM'],
        'ip'        => $_SERVER['HTTP_X_FORWARDED_FOR'],
    ];

    $check_user = $auth->get_user('id_extern', $data['id_extern']);
    
    if($check_user){
        $auth->extern_login($data);
    } else{
        $auth->extern_register($data);
    }

}else{
    $app->error('Google authentification failed!');
}