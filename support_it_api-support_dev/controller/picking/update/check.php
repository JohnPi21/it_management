<?php
use Support\Picking\Picking;

global $db;

$id         =   $input->post('id', 'int')->value;
$table      =   $input->post('table')->value;

$picking = new Picking();
$picking->getCurrent($table, $id)->check($table, $id);