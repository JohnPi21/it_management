<?php
global $db;

$db->where('type', 'SCANER');
$scan = $db->get('picking_devices');

echo json_encode($scan);