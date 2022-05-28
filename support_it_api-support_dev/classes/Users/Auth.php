<?php

declare(strict_types=1);

namespace Support\Users;

use Support\Users\User;

class Auth extends User
{
    public ?array $session = null;
    private ?array $vuex_data = null;
    private string $domain = 'alexwork.xyz';

    //Check if user has cookie and send back vuex data or send ero
    function __construct($cookie, $online = true, $init = false)
    {
        global $app;

        $this->get_session($cookie);

        if (empty($this->user) && $online) {
            $app->error('Please login!');
        }
        if ($init) {
            $this->init();
        }
    }


    //Sends data back to user
    public function init(): void
    {
        global $app;

        if (isset($this->vuex_data)) {
            echo json_encode($this->vuex_data);
        } else {
            $app->error('Please login!');
        }
    }


    //Register from an external source (social media)
    public function extern_register($data): void
    {
        $this->create_user($data);

        $this->extern_login($data);
    }


    //Login from an external source (social media)
    public function extern_login($data)
    {
        //Get the user I want to authenitificate
        $this->get_user('id_extern', $data['id_extern']);

        //Create login log
        $this->create_login($data);

        //Create cookie
        $this->set_session();

        //Sends the data back to user
        $this->init();
    }


    //Set the user cookie based on session_id
    public function set_session(): self
    {
        //Create encription
        $vuex_data =
            [
                'id'        => $this->session['id'],
                'id_user'   => $this->session['id_user'],
                'data_login' => $this->session['data_login'],
                'online'    => true,
            ];

        $enc_cookie = $this->encrypt(json_encode($vuex_data));

        $this->vuex_data = $vuex_data;

        //Set cookie
        setcookie(
            'SP_token',
            $enc_cookie,
            [
                'expires'   => time() + 60 * 60 * 24 * 30,
                'path'      => '/',
                'domain'    => '.' . $this->domain,
                'secure'    => true,
                'httponly'  => true,
                'samesite'  => 'Lax'
            ]
        );

        return $this;
    }


    //Get user session cookie, and decrypt
    public function get_session($name): self
    {
        if (isset($_COOKIE[$name])) {
            $dec_cookie = $this->decrypt($_COOKIE[$name]);
            if ($dec_cookie) {

                $data = json_decode($dec_cookie, true);

                $this->get_user('id', $data['id_user']);

                $this->vuex_data = $data;

                return $this;
            }
        }
        return $this;
    }


    //Unset cookie (should force a vuex clear and redirect to login page)
    public function unset_session($name): void
    {
        global $app;

        if (isset($_COOKIE[$name])) {

            setcookie(
                'SP_token',
                'EXPIRED',
                [
                    'expires'   => time() - 3600,
                    'path'      => '/',
                    'domain'    => '.' . $this->domain,
                    'secure'    => true,
                    'httponly'  => true,
                    'samesite'  => 'Lax'
                ]
            );

            $app->message('Logout realizat!');
        }
    }


    //Create user log with extra data about login session
    public function create_login($data): self
    {
        global $crud;

        $log =
            [
                'id_user'   => $this->user['id'],
                'ip'        => $data['ip'],
                'browser'   => $data['browser'],
                'os'        => $data['os'],
            ];
        $id = $crud->createEntry('useri_login_log', $log);
        $this->get_login('id', $id);

        return $this;
    }


    //Get user login log
    public function get_login($key, $value): self
    {
        global $crud;
        $this->session = $crud->getOne('useri_login_log', $key, $value);

        return $this;
    }


    //Encryption funcion for cookies and others
    public function encrypt($message): mixed
    {
        $key = '9783aa2a045e568f3e4640ea446111d9391feba70bb2e1adf8d92c70f9536f0f';
        $cipher_algo = 'aes-256-ctr';

        $iv_length = openssl_cipher_iv_length($cipher_algo);
        $iv = openssl_random_pseudo_bytes($iv_length);

        $ciphertext = openssl_encrypt($message, $cipher_algo, $key, OPENSSL_RAW_DATA, $iv);

        if (!$ciphertext) {
            return false;
        }
        return base64_encode($iv . $ciphertext);
    }


    //Decryption function for cookies and other
    public function decrypt($encrypted): mixed
    {
        $key = '9783aa2a045e568f3e4640ea446111d9391feba70bb2e1adf8d92c70f9536f0f';
        $cipher_algo = 'aes-256-ctr';

        $message = base64_decode($encrypted, true);
        if ($message === false) {
            return false;
        }

        $iv_length = openssl_cipher_iv_length($cipher_algo);
        $iv = mb_substr($message, 0, $iv_length, '8bit');
        $ciphertext = mb_substr($message, $iv_length, null, '8bit');

        $decoded = openssl_decrypt($ciphertext, $cipher_algo, $key, OPENSSL_RAW_DATA, $iv);

        if (!$decoded) {
            return false;
        }
        return $decoded;
    }
}
