<?php
use Support\Picking\Picking;

$tag            = $input->req('TAG-ul nu este setat!')
                        ->post('tag', 'alphanum')
                        ->mustNotExist('tag','picking_devices')
                        ->min(12,'Numele scanerului este prea scurt!')
                        ->max(12,'Numele scanerului este prea lung!')
                        ->value;
$marca          = $input->post('marca', 'alphanumspace')
                        ->min(2,'Numele marcii este prea scurt!')
                        ->max(16,'Numele marcii este prea lung!')
                        ->value;
$model          = $input->post('model', 'alphanumspace')
                        ->min(1,'Numele modelului este prea scurt!')
                        ->max(16,'Numele modelului este prea lung!')
                        ->value;
$sn             = $input->req('SN-ul nu este setat!')
                        ->post('sn', 'alphanum')
                        ->mustNotExist('sn', 'picking_devices')
                        ->min(10,'SN-ul introdus este incorect!')
                        ->max(10,'SN-ul introdus este incorect!')
                        ->value;
$status         = $input->req('Statusul nu este setat!')->post('status', 'words')->value;
$obs            = $input->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;

$data = 
[
    'tag'       => $tag,
    'type'      => 'SCANER',
    'marca'     => $marca,
    'model'     => $model,
    'sn'        => $sn,
    'status'    => $status,
    'obs'       => $obs
];

//Instantiere picking
$picking = new Picking($data);

//Create entry
$id = $picking->createEntry('picking_devices');

//Client response
$app->message('Scaner adaugat!');