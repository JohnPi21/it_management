<?php

use Support\Picking\Picking;

$id = $input->post('id', 'int')->value;

$picking = new Picking();

$picking->statusMustBe('picking_sim', $id, ['INACTIV', 'STOC'])
        ->deleteEntry('picking_sim', $id);

$app->message('SIM-UL a fost sters');
