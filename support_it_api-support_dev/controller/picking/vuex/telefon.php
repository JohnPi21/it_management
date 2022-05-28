<?php
global $db;

$cols = ['id','tag'];
$db->where('status', 'STOC');
$db->where('type', 'TELEFON');
$telefon = $db->get('picking_devices', null, $cols);

echo json_encode($telefon);