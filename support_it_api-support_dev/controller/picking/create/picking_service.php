<?php
use Support\Picking\Picking;

$id_depozit     = $input    ->req('Depozitul nu este selectat!')
                            ->post('id_depozit', 'int')
                            ->value;
$id_device      = $input    ->post('id_device', 'int')->value;
$obs            = $input    ->post('obs')->min(10, 'Prea putine caractere in campul observatii!')->value;
$service        = $input    ->req('Service-ul nu este selectat!')
                            ->post('service', 'words')
                            ->value;
$status         = $input    ->req('Statusul nu este setat!')
                            ->post('status', 'words')
                            ->value;
$data_trimis    = $input    ->post('data_trimis', 'date_time')->value;
$data_primit    = $input    ->post('data_primit', 'date_time')->value;

$data = 
[
    'id_depozit'    => $id_depozit,
    'id_device'     => $id_device,
    'obs'           => $obs,
    'service'       => $service,
    'status'        => $status,
    'data_trimis'   => $data_trimis,
    'data_primit'   => $data_primit
];

$picking = new Picking($data);

//Check devices status
$picking->statusMustBe('picking_devices', $id_device, ['STOC']);

//Create service entry
$id = $picking->createEntry('picking_service');

//Update
$picking->updateStatus('picking_devices', $id_device, 'SERVICE');

//Create user action history

$app->message('Device trimis in service!');