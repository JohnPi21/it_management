<?php
use Support\Picking\Picking;

global $db;

$id             = $input    ->req('ID-ul campului curent este necunoscut!')
                            ->post('id', 'int')
                            ->value;
$tag            = $input    ->post('tag', 'alphanum')
                            ->mustNotExist('tag','picking_devices')
                            ->min(12,'Numele scanerului este prea scurt!')
                            ->max(12,'Numele scanerului este prea lung!')
                            ->value;
$marca          = $input    ->post('marca', 'alphanumspace')
                            ->min(2,'Numele marcii este prea scurt!')
                            ->max(16,'Numele marcii este prea lung!')
                            ->value;
$model          = $input    ->post('model', 'alphanumspace')
                            ->min(1,'Numele modelului este prea scurt!')
                            ->max(16,'Numele modelului este prea lung!')
                            ->value;
$mac            = $input     ->post('mac', 'mac')->value;
$sn             = $input    ->post('sn', 'alphanum')
                            ->mustNotExist('sn', 'picking_devices')
                            ->min(10,'SN-ul introdus este incorect!')
                            ->max(10,'SN-ul introdus este incorect!')
                            ->value;
$status         = $input    ->post('status', 'words')->value;
$obs            = $input    ->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;

$data = 
[
    'tag'               => $tag,
    'type'              => 'SCANER',
    'marca'             => $marca,
    'model'             => $model,
    'sn'                => $sn,
    'mac'                => $mac,
    'status'            => $status,
    'obs'               => $obs,
];

//Picking
$picking = new Picking($data);

//Create entry
$picking->filterNull()->updateData('picking_devices', $id);

//Response to client
$app->message('Scaner updatat!');