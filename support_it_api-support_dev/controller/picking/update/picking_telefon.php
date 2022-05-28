<?php
use Support\Picking\Picking;

global $db;

$id             = $input    ->req('ID-ul campului curent este necunoscut!')
                            ->post('id', 'int')
                            ->value;

$tag            = $input    ->post('tag', 'alphanum')
                            ->mustNotExist('tag','picking_devices')
                            ->min(8,'Numele telefonului este prea scurt!')
                            ->max(8,'Numele telefonului este prea lung!')
                            ->value;
$marca          = $input    ->post('marca', 'alphanumspace')
                            ->min(2,'Numele marcii este prea scurt!')
                            ->max(16,'Numele marcii este prea lung!')
                            ->value;
$model          = $input    ->post('model', 'alphanumspace')
                            ->min(1,'Numele modelului este prea scurt!')
                            ->max(16,'Numele modelului este prea lung!')
                            ->value;
$sn             = $input    ->post('sn', 'alphanum')
                            ->min(1,'SN-ul este prea scurt!')
                            ->max(17,'SN-ul este prea lung!')
                            ->value;                            
$imei           = $input    ->post('imei', 'alphanum')
                            ->min(15,'IMEI-ul introdus este incorect!')
                            ->max(15,'IMEI-ul introdus este incorect!')
                            ->mustNotExist('imei', 'picking_devices')
                            ->mustNotExist('imei2', 'picking_devices')
                            ->value;
$imei2           = $input   ->post('imei2', 'alphanum')
                            ->min(15,'IMEI-ul introdus este incorect!')
                            ->max(15,'IMEI-ul introdus este incorect!')
                            ->mustNotExist('imei', 'picking_devices')
                            ->mustNotExist('imei2', 'picking_devices')
                            ->value;
$mac            =  $input   ->post('mac', 'mac')
                            ->min(17,'MAC-ul introdus este incorect!')
                            ->max(17,'MAC-ul introdus este incorect!')
                            ->value;
$status         = $input    ->post('status', 'words')->value;
$obs            = $input    ->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;

$data = 
[
    'tag'               => $tag,
    'marca'             => $marca,
    'model'             => $model,
    'sn'                => $sn,
    'imei'              => $imei,
    'imei2'             => $imei2,
    'mac'               => $mac,
    'status'            => $status,
    'obs'               => $obs
];
//Create picking object
$picking = new Picking($data);

//Create entry
$picking->filterNull()->updateData('picking_devices', $id);

$app->message('Telefon updatat!');