<?php
use Support\Picking\Picking;

$nr_tel =   $input  ->req('Numarul de telefon nu e setat!')
                    ->post('nr_tel', 'tel')
                    ->min(9, 'Numarul de telefon este prea scurt!')
                    ->max(12, 'Numarul de telefon este prea lung!')
                    ->mustNotExist('nr_tel', 'picking_sim')
                    ->value;

$ip     =   $input  ->post('ip', 'ip', null)
                    ->mustNotExist('ip', 'picking_sim')
                    ->value;
                
$ssn    =   $input  ->req('SSN-ul nu e setat')
                    ->post('ssn', 'int')
                    ->min(13, 'SSN-ul este prea scurt!')
                    ->max(14, 'SSN-ul este prea lung!')
                    ->mustNotExist('ssn','picking_sim')
                    ->value;

$puk    =   $input  ->post('puk', 'int', null)
                    ->min(9, 'PUK-ul este prea scurt')
                    ->max(9, 'PUK-ul este prea scurt')
                    ->value;

$status =   $input  ->req('Statusul nu e setat')
                    ->post('status', 'alpha')
                    ->min(2, 'Statusul nu e corect!')
                    ->value;

$data = 
[
    'nr_tel'    => $nr_tel,
    'ip'        => $ip,
    'ssn'       => $ssn,
    'puk'       => $puk,
    'status'    => $status
];

$picking = new Picking($data);

$id = $picking->createEntry('picking_sim');

$app->message('SIM adaugat!');
