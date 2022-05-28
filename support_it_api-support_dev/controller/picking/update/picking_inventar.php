<?php
use Support\Picking\Picking;

global $db;

$id             = $input        ->req('ID-ul campului curent este necunoscut!')
                                ->post('id', 'int')
                                ->value;
$id_telefon     = $input        ->post('id_telefon', 'int')
                                ->mustNotExist('id_telefon','picking_inventar')
                                ->value;
$id_scaner      = $input        ->post('id_scaner', 'int')
                                ->mustNotExist('id_scaner','picking_inventar')
                                ->value;
$id_sim         = $input        ->post('id_sim', 'int')
                                ->mustNotExist('id_sim','picking_inventar')
                                ->value;
$id_depozit     = $input        ->post('id_depozit', 'int')
                                ->value;
$user           = $input        ->post('user')->value;
$obs            = $input        ->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;

$status_telefon = $input        ->post('status_telefon', 'words')->value;
$status_scaner  = $input        ->post('status_scaner', 'words')->value;
$status_sim     = $input        ->post('status_sim', 'words')->value;
$data_trimis    = $input        ->post('data_trimis', 'date_time')->value;

$data = 
[
    'id_telefon'        =>$id_telefon,
    'id_scaner'         =>$id_scaner,
    'id_sim'            =>$id_sim,
    'id_depozit'        =>$id_depozit,
    'user'              =>$user,
    'obs'               =>$obs,
    'data_trimis'       =>$data_trimis,
];

$picking = new Picking($data);

//CHECK STATUS
$picking->statusMustBe('picking_devices', $id_telefon, ['STOC'])
        ->statusMustBe('picking_devices', $id_scaner, ['STOC'])
        ->statusMustBe('picking_sim', $id_sim, ['STOC']);

//Update status
$picking->updateStatus('picking_devices', $id_telefon, 'INVENTAR')
        ->updateStatus('picking_devices', $id_scaner, 'INVENTAR')
        ->updateStatus('picking_sim', $id_sim, 'ACTIV');

//Update current devices status
$picking->getCurrent('picking_inventar', $id)
        ->updateCurrent('picking_devices', 'telefon', $status_telefon)
        ->updateCurrent('picking_devices', 'scaner', $status_scaner)
        ->updateCurrent('picking_sim', 'sim', $status_sim);

//Update data
$picking->filterNull()->updateData('picking_inventar', $id);

//Create User Action
        
//Check new devices Status
$picking->statusMustBe('picking_devices', $id_telefon, ['INVENTAR'])
        ->statusMustBe('picking_devices', $id_scaner, ['INVENTAR'])
        ->statusMustBe('picking_sim', $id_sim, ['ACTIV']);

//Response to client
$app->message('Update realizat cu succes!');