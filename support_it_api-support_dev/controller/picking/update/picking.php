<?php

use Support\Picking\Picking;

global $db;

$id             = $input->req('ID-ul campului curent este necunoscut!')
        ->post('id', 'int')
        ->value;
$id_telefon     = $input->post('id_telefon', 'int')
        ->mustNotExist('id_telefon', 'picking')
        ->value;
$id_scaner      = $input->post('id_scaner', 'int')
        ->mustNotExist('id_scaner', 'picking')
        ->value;
$id_sim         = $input->post('id_sim', 'int')
        ->mustNotExist('id_sim', 'picking')
        ->value;
$id_depozit     = $input->post('id_depozit', 'int')
        ->value;
$id_cuseta      = $input->post('id_cuseta', 'int')
        ->mustNotExist('id_cuseta', 'picking')
        ->value;
$user           = $input->post('user')->value;
$tel_user       = $input->post('tel_user', 'tel')->value;
$obs            = $input->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;

$status_telefon = $input->post('status_telefon', 'words')->value;
$status_scaner  = $input->post('status_scaner', 'words')->value;
$status_sim     = $input->post('status_sim', 'words')->value;
$status_cuseta  = $input->post('status_cuseta', 'words')->value;

//Informatii
$data =
        [
                'id_telefon'        => $id_telefon,
                'id_scaner'         => $id_scaner,
                'id_sim'            => $id_sim,
                'id_depozit'        => $id_depozit,
                'id_cuseta'         => $id_cuseta,
                'user'              => $user,
                'tel_user'          => $tel_user,
                'obs'               => $obs,
        ];
//Instantiate picking with $data
$picking = new Picking($data);

//CHECK STATUS
$picking->statusMustBe('picking_devices',       $id_telefon,    ['STOC'])
        ->statusMustBe('picking_devices',       $id_scaner,     ['STOC'])
        ->statusMustBe('picking_sim',           $id_sim,        ['STOC'])
        ->statusMustBe('picking_cuseta',        $id_cuseta,     ['LIBER']);

//Update replaced devices status AND send to service is STATUS == SERVICE
$picking->getCurrent('picking', $id)
        ->updateCurrent('picking_devices',      'telefon',      $status_telefon)
        ->updateCurrent('picking_devices',      'scaner',       $status_scaner)
        ->updateCurrent('picking_sim',          'sim',          $status_sim)
        ->updateCurrent('picking_cuseta',       'cuseta',       $status_cuseta);

//Set unknown columns
$unknown = ['id_telefon' => $id_telefon, 'id_scaner' => $id_scaner, 'id_sim' => $id_sim];

//Update entry
$picking->filterNull()->setUnknown($unknown)->updateData('picking', $id);

//Update status
$picking->updateStatus('picking_devices',       $id_telefon,    'UZ')
        ->updateStatus('picking_devices',       $id_scaner,     'UZ')
        ->updateStatus('picking_sim',           $id_sim,        'ACTIV')
        ->updateStatus('picking_cuseta',        $id_cuseta,     'UZ');

//Check new devices Status
$picking->statusMustBe('picking_devices',       $id_telefon,    ['UZ'])
        ->statusMustBe('picking_devices',       $id_scaner,     ['UZ'])
        ->statusMustBe('picking_sim',           $id_sim,        ['ACTIV'])
        ->statusMustBe('picking_cuseta',        $id_cuseta,     ['UZ']);

$app->message('Picking updatat!');
