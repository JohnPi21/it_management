<?php

use Support\Picking\Picking;

//Check input
$id =       $input->post('id', 'int')->value;
$column =   $input->post('column', 'alphanumspace')->value;

//Set allowed fields to be deleted
$allowed = ['user', 'tel_user', 'obs'];

//Instantiate picking
$picking = new Picking();

//Delete selected data
$picking->deleteData('picking', $id, $column, $allowed);

//Response to client
$app->message('Informatia a fost stearsa!');
