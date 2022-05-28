<?php

use Support\Picking\Picking;

//Check input
$id = $input->post('id', 'int')->value;

//Picking
$picking = new Picking();

//Check conditions
$picking->deleteEntry('picking_service', $id);

//Message
$app->message('Intrarea a fost stearsa!');
