<?php

use Support\Picking\Picking;

//Check input
$id =       $input->post('id', 'int')->value;
$column =   $input->post('column', 'alphanumspace')->value;

//Set allowed fields to be deleted
$allowed = ['ip', 'puk'];

//Instantiate picking
$picking = new Picking();

//Delete selected data
$picking->deleteData('picking_sim', $id, $column, $allowed);

//Message
$app->message('Informatia a fost stearsa!');
