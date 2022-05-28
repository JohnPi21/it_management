<?php
global $db;

$cols = ['id',"nr_tel as 'tag'"];
$db->where('status', 'STOC');
$sim = $db->get('picking_sim', null, $cols);

echo json_encode($sim);