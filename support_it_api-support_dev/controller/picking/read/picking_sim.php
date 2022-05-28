<?php
global $db;

$sims = $db->get('picking_sim');

echo json_encode($sims);