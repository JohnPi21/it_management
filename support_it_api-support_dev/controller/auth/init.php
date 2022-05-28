<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use Support\Users\Auth;

$auth = new Auth('SP_token', true, true);