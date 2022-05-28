<?php

use Support\Picking\Picking;

$id             = $input->post('id', 'int')->value;

$picking = new Picking();

$picking->getCurrent('picking_inventar', $id)
        ->updateCurrent('picking_devices', 'telefon', 'STOC')
        ->updateCurrent('picking_devices', 'scaner', 'STOC')
        ->updateCurrent('picking_sim', 'sim', 'STOC')
        ->deleteEntry('picking_inventar', $id);

//Response to client
$app->message('Relatia a fost stearsa cu succes');
