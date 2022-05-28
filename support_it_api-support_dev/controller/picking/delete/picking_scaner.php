<?php

use Support\Picking\Picking;

//Check input
$id = $input->post('id', 'int')->value;

//Picking
$picking = new Picking();

//Check conditions
$picking->statusMustBe('picking_devices', $id, ['STOC', 'NECUNOSCUT', 'CASAT'])
        ->deleteEntry('picking_devices', $id);

//Message
$app->message('Scanerul a fost sters!');
