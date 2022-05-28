<?php

use Support\Picking\Picking;
use Support\Users\Actions;
use Support\Input\Input;

$log = new Actions(5);

$input = new Input();

$id_telefon     = $input->req('Telefonul nu este selectat!')
        ->post('id_telefon')
        ->mustNotExist('id_telefon', 'picking')
        ->value;
$id_scaner      = $input->req('Scanerul nu este selectat!')
        ->post('id_scaner')
        ->mustNotExist('id_scaner', 'picking')
        ->value;
$id_sim         = $input->req('SIM-ul nu este selectat!')
        ->post('id_sim')
        ->mustNotExist('id_sim', 'picking')
        ->value;
$id_depozit     = $input->req('Depozitul nu este selectat!')
        ->post('id_depozit', 'int')
        ->value;
$id_cuseta      = $input->post('id_cuseta', 'int')
        ->mustNotExist('id_cuseta', 'picking')
        ->value;
$user           = $input->post('user', 'alphanumspace')->value;
$tel_user       = $input->post('tel_user', 'tel')->value;
$obs            = $input->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;

$data =
        [
                'id_telefon'        => $id_telefon,
                'id_scaner'         => $id_scaner,
                'id_sim'            => $id_sim,
                'id_depozit'        => $id_depozit,
                'id_cuseta'         => $id_cuseta,
                'user'              => $user,
                'tel_user'          => $tel_user,
                'obs'               => $obs
        ];
//Instantiate Picking with $data
$picking = new Picking($data);

//CHECK STATUS
$picking->statusMustBe('picking_devices',       $id_telefon,    ['STOC'])
        ->statusMustBe('picking_devices',       $id_scaner,     ['STOC'])
        ->statusMustBe('picking_sim',           $id_sim,        ['STOC'])
        ->statusMustBe('picking_cuseta',        $id_cuseta,     ['LIBER']);

//Set unknown columns
$unknown = ['id_telefon' => $id_telefon, 'id_scaner' => $id_scaner, 'id_sim' => $id_sim];

//Create entry
$id = $picking->setUnknown($unknown)->createEntry('picking');

//Create history action
// $log->action_log('picking', $id, 'CREATE');

//Update status
$picking->updateStatus('picking_devices', $id_telefon, 'UZ')
        ->updateStatus('picking_devices', $id_scaner, 'UZ')
        ->updateStatus('picking_sim', $id_sim, 'ACTIV')
        ->updateStatus('picking_cuseta', $id_cuseta, 'UZ');

//Check new Status
$picking->statusMustBe('picking_devices', $id_telefon, ['UZ'])
        ->statusMustBe('picking_devices', $id_scaner, ['UZ'])
        ->statusMustBe('picking_sim', $id_sim, ['ACTIV'])
        ->statusMustBe('picking_cuseta', $id_cuseta, ['UZ']);

$app->message('Relatie creata cu succes!');
