<?php
global $db;

$cols = ['id','tag'];
$db->where('status', 'STOC');
$db->where('type', 'SCANER');
$scaner = $db->get('picking_devices', null, $cols);

echo json_encode($scaner);