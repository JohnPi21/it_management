<?php

use Support\Picking\Picking;

$id_telefon     = $input->req('Telefonul nu este selectat')
        ->post('id_telefon', 'int')
        ->mustNotExist('id_telefon', 'picking_inventar')
        ->value;
$id_scaner      = $input->req('Scanerul nu este selectat')
        ->post('id_scaner', 'int')
        ->mustNotExist('id_scaner', 'picking_inventar')
        ->value;
$id_sim         = $input->req('SIM-ul nu este selectat')
        ->post('id_sim', 'int')
        ->mustNotExist('id_sim', 'picking_inventar')
        ->value;
$id_depozit     = $input->req('Depozitul nu este selectat')
        ->post('id_depozit', 'int')
        ->value;
$user           = $input->post('user')->value;
$obs            = $input->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;
$data_trimis    = $input->post('data_trimis', 'date_time')->value;

$data =
        [
                'id_telefon'        => $id_telefon,
                'id_scaner'         => $id_scaner,
                'id_sim'            => $id_sim,
                'id_depozit'        => $id_depozit,
                'user'              => $user,
                'obs'               => $obs,
                'data_trimis'       => $data_trimis,
        ];
//Create user object and check level

//Instantiate picking object
$picking = new Picking($data);

//CHECK STATUS
$picking->statusMustBe('picking_devices', $id_telefon, ['STOC'])
        ->statusMustBe('picking_devices', $id_scaner, ['STOC'])
        ->statusMustBe('picking_sim', $id_sim, ['STOC']);

//Create entry
$id = $picking->createEntry('picking_inventar');

//Update status
$picking->updateStatus('picking_devices', $id_telefon, 'INVENTAR')
        ->updateStatus('picking_devices', $id_scaner, 'INVENTAR')
        ->updateStatus('picking_sim', $id_sim, 'ACTIV');

//Check new Status
$picking->statusMustBe('picking_devices', $id_telefon, ['INVENTAR'])
        ->statusMustBe('picking_devices', $id_scaner, ['INVENTAR'])
        ->statusMustBe('picking_sim', $id_sim, ['ACTIV']);

//Message to client
$app->message('Relatie creata cu succes!');
