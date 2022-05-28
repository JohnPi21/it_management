<?php
use Support\Picking\Picking;

global $db;

$id             = $input    ->req('ID-ul campului curent este necunoscut!')
                            ->post('id', 'int')
                            ->value;
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
    'obs'           => $obs,
    'service'       => $service,
    'status'        => $status,
    'data_trimis'   => $data_trimis,
    'data_primit'   => $data_primit,
];

$picking = new Picking($data);

//Update status in devices
$picking->getCurrent('picking_service', $id)
        ->updateService($status);
    
//Create entry
$picking->filterNull()->updateData('picking_service', $id);

//Client response
$app    ->message('Service device actualizat!');
