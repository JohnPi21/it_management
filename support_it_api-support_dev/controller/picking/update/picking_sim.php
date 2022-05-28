<?php
use Support\Picking\Picking;

global $db;

$id             = $input    ->req('ID-ul campului curent este necunoscut!')
                            ->post('id', 'int')
                            ->value;

$nr_tel         = $input    ->post('nr_tel', 'tel')
                            ->mustNotExist('nr_tel','picking_sim')
                            ->min(8,'Numarul de telefon este incorect!')
                            ->max(8,'Numarul de telefon este incorect!')
                            ->value;
$ip             = $input    ->post('ip', 'ip')
                            ->mustNotExist('nr_tel','picking_sim')
                            ->min(7,'IP-ul este prea scurt!')
                            ->max(15,'IP-ul este prea lung!')
                            ->value;
$ssn             = $input   ->post('ssn', 'int')
                            ->mustNotExist('ssn','picking_sim')
                            ->min(12,'SSN-ul este incorect!')
                            ->max(12,'SSN-ul este incorect!')
                            ->value;                            
$puk             = $input   ->post('puk', 'int')
                            ->min(8,'PUK-ul introdus este incorect!')
                            ->max(8,'PUK-ul introdus este incorect!')
                            ->value;
$status         = $input    ->post('status', 'words')->value;

$data = 
[
    'id'                => $id,
    'nr_tel'            => $nr_tel,
    'ip'                => $ip,
    'ssn'               => $ssn,
    'puk'               => $puk,
    'status'            => $status
];

$picking = new Picking($data);

//Create entry
$picking->filterNull()->updateData('picking_sim', $id);

//Client repsonse
$app->message('SIM-ul a fost updatat!');