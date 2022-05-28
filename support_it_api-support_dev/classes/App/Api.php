<?php

declare(strict_types=1);
//Regula la namespace e Support care e folderul classes configurat din composer.json 
namespace Support\App;

class Api extends App
{

    public array $content_type = [];

    function __construct(bool $axios = true, bool $db = true)
    {
        global $_POST, $mysql;

        if ($axios == true) {
            $_POST = file_get_contents('php://input');
            $_POST = json_decode($_POST, true);
        }

        if ($db === true) {
            $this->db($mysql['prod']);
            $this->crud();
        }

        return $this;
    }

    public function allowed_domains($domains): self
    {
        foreach ($domains as $domain) {
            // $this->allowed_domains[] = 'http://'.$domain;
            // $this->allowed_domains[] = 'http://www.'.$domain;
            $this->allowed_domains[] = 'https://' . $domain;
            $this->allowed_domains[] = 'https://www.' . $domain;
        }
        return $this;
    }

    public function request($type = false)
    {
        if ($type != $_SERVER['REQUEST_METHOD']) {
            die;
        }
    }


    public function cors(): self
    {
        global $app;

        if (!isset($_SERVER['HTTP_ORIGIN']) && !isset($_SERVER['HTTP_BACK_ACCESS'])) {
            $app->error('Direct access is not allowed');
        }

        if (isset($_SERVER['HTTP_BACK_ACCESS']) && $_SERVER['HTTP_BACK_ACCESS'] != 'inside') {
            $app->error('Direct access is not allowed');
        }

        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        } else {
            header('Access-Control-Allow-Origin: *');
        }

        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: back-access, X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding');

        return $this;
    }

    public function headers(array $headers = null): self
    {

        if ($headers == null) {
            return $this;
        }

        if (is_array($headers) && sizeof($headers) > 0) {
            foreach ($headers as $key => $value) {
                header($value);
            }
            return $this;
        }


        switch ($headers) {
            case 'json':
                header('Content-Type: application/json');
                return $this;
                break;
        }
    }
}
