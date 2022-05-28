<?php
global $db;

$cuseta = $db->get('picking_cuseta');

echo json_encode($cuseta);