<?php
use Support\Picking\Picking;

$tag        =  $input   ->req('Tag-ul nu este completat!')
                        ->post('tag', 'alphanum')
                        ->min(8, 'Tag-ul este prea scurt!')
                        ->max(8, 'Tag-ul este prea lung!')
                        ->mustNotExist('tag', 'picking_devices')
                        ->value;

$marca      =  $input   ->post('marca', 'alphanumspace')->value;
$model      =  $input   ->post('model', 'alphanumspace')->value;
$sn         =  $input   ->post('sn', 'alphanum')->value;

$imei       =  $input   ->req('IMEI-ul este necompletat!')
                        ->post('imei', 'alphanum')
                        ->min(15, 'IMEI-ul este prea scurt!')
                        ->max(15, 'IMEI-ul este prea lung!')
                        ->mustNotExist('imei', 'picking_devices')
                        ->mustNotExist('imei2', 'picking_devices')
                        ->value;
$imei2       =  $input  ->post('imei', 'alphanum')
                        ->min(15, 'IMEI-ul 2 este prea scurt!')
                        ->max(15, 'IMEI-ul 2 este prea lung!')
                        ->mustNotExist('imei', 'picking_devices')
                        ->mustNotExist('imei2', 'picking_devices')
                        ->value;
$mac        =  $input   ->post('mac', 'mac')->value;

$status     =  $input   ->req('Statusul este necompletat!')
                        ->post('status', 'words')
                        ->max(12, 'Statusul este prea lung!')
                        ->value;

$obs        =  $input   ->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;

$data = 
[
    'tag'       => $tag,
    'type'      => 'TELEFON',
    'marca'     => $marca,
    'model'     => $model,
    'sn'        => $sn,
    'imei'      => $imei,
    'imei2'      => $imei2,
    'mac'       => $mac,
    'status'    => $status,
    'obs'       => $obs,
];

$picking = new Picking($data);

//Create entry
$id = $picking->createEntry('picking_devices');

//Message to user
$app->message('Telefon adaugat!');