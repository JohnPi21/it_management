<?php
global $db;

$cols = ['id', "numar as 'tag'"];
$db->where('status', 'LIBER');
$cuseta = $db->get('picking_cuseta', null, $cols);

echo json_encode($cuseta);