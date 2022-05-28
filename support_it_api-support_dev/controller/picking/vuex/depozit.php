<?php
global $db;

$cols = ['id','nume as tag', 'indicativ'];
$warehouse = $db->get('depozite', null, $cols);

echo json_encode($warehouse);