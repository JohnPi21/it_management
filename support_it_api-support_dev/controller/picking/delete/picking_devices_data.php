<?php

use Support\Picking\Picking;

//Check input
$id =       $input->post('id', 'int')->value;
$column =   $input->post('column', 'alphanumspace')->value;

//Set allowed fields to be deleted
$allowed = ['marca', 'model', 'obs', 'mac'];

//Instantiate picking
$picking = new Picking();

//Delete selected data
$picking->deleteData('picking_devices', $id, $column, $allowed);

//Response to client
$app->message('Informatia a fost stearsa!');
