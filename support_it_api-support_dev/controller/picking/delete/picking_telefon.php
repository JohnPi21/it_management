<?php

use Support\Picking\Picking;

$id             = $input->post('id', 'int')->value;

$picking = new Picking();

//Check status device and delete
$picking->statusMustBe('picking_devices', $id, ['STOC', 'CASAT', 'NECUNOSCUT'])
        ->deleteEntry('picking_devices', $id);

//Message to user
$app->message('Telefonul a fost sters');
