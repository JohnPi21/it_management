<?php
global $db;

$db->where('type', 'TELEFON');
$telefon = $db->get('picking_devices');

echo json_encode($telefon);