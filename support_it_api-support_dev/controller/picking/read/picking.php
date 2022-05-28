<?php

global $db;

$picking = $db->rawQuery("
SELECT p.id, w.nume as 'depozit', c.numar as 'cuseta', dt.tag as 'telefon', dt.imei, ds.tag as 'scaner', ds.sn, s.nr_tel, s.ssn, p.user, p.tel_user, p.obs, p.checked 
FROM picking p 
LEFT JOIN depozite w 
ON p.id_depozit = w.id 
LEFT JOIN picking_devices dt 
ON p.id_telefon = dt.id 
LEFT JOIN picking_devices ds 
ON p.id_scaner = ds.id 
LEFT JOIN picking_sim s 
ON p.id_sim = s.id 
LEFT JOIN picking_cuseta c 
ON p.id_cuseta = c.id 
ORDER BY p.id
");

echo json_encode($picking);
