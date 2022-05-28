<?php
global $db;

$picking = $db->rawQuery("
SELECT p.id, w.nume as 'depozit', dt.tag as 'telefon', dt.imei, ds.tag as 'scaner', ds.sn, s.nr_tel, s.ssn, p.user, p.data_trimis, p.obs 
FROM picking_inventar p 
LEFT JOIN depozite w 
ON p.id_depozit = w.id 
LEFT JOIN picking_devices dt 
ON p.id_telefon = dt.id 
LEFT JOIN picking_devices ds 
ON p.id_scaner = ds.id 
LEFT JOIN picking_sim s 
ON p.id_sim = s.id 
ORDER BY p.id asc
");

echo json_encode($picking);