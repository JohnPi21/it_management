<?php
global $db;

$warehouse = $db->get('depozite');

echo json_encode($warehouse);