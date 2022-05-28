<?php

namespace Support\General;

class Debugg
{

    public $start_time;
    public $end_time;
    //Se invoca construct cu functia pe care o doresc, iar la finalul scriptului unde doresc masurata performanta se invoca stop debugg sau db trace
    public function __construct(bool $db = true, bool $memory = false)
    {
        if ($db == true) {
            $this->db_start_trace();
        }
        if ($memory == true) {
            $this->start_debugg();
        }
    }

    public function start_debugg()
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        $this->start_time = microtime(true);
    }

    public function stop_debbug()
    {
        $end_time = microtime(true);
        $time = $end_time - $this->start_time;
        echo 'Full page was executed in: ' . number_format($time, 8) . '<br>';
        echo 'Memory usage: ' . number_format(memory_get_usage() / 1024 / 1024, 2) . ' MB<br>';
        echo 'Peak Memory usage: ' . number_format(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB<br>';
    }
    public function db_start_trace()
    {
        global $db;
        $db->setTrace(true);
    }
    public function db_trace()
    {
        global $db;
        print_r($db->trace);
    }

    public function headers()
    {
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Access-Control-Allow-Methods: *');
    }
}
