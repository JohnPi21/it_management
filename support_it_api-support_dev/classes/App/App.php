<?php

declare(strict_types=1);

namespace Support\App;

use MysqliDb;
use Support\Database\Database;

class App
{
    public array $allowed_domains = [];
    public array $message = [];


    public function db(array $conn): object
    {
        global $db;
        $db = new MysqliDb($conn);
        return ($db);
    }
    public function crud(): object
    {
        global $crud;
        $crud = new Database;
        return $crud;
    }

    public function message(string $message, string $type = 'info'): void
    {
        //$type = Info (blue or green) || warn (yellow or red) 
        $msg = ["error" => false, 'type' => $type, "message" => $message];
        array_push($this->message, $msg);

        echo json_encode($this->message);
        die();
    }

    public function error(string $err): void
    {
        $msg = ["error" => true, "message" => $err];
        array_push($this->message, $msg);

        echo json_encode($this->message);
        die();
    }
}
