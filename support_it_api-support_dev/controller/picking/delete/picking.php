<?php

use Support\Picking\Picking;

$id = $input->post('id', 'int')->value;

$picking = new Picking();

//Update picking devices status on delete and DELETE
$picking->getCurrent('picking', $id)
        ->updateCurrent('picking_devices', 'telefon', 'STOC')
        ->updateCurrent('picking_devices', 'scaner', 'STOC')
        ->updateCurrent('picking_sim', 'sim', 'STOC')
        ->updateCurrent('picking_cuseta', 'cuseta', 'LIBER')
        ->deleteEntry('picking', $id);

//Response to client
$app->message('Relatia a fost stearsa cu succes');
