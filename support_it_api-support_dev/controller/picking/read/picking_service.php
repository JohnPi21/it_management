<?php
global $db;

$servicepick = $db->rawQuery("
SELECT s.id, w.nume as 'depozit', d.tag as 'tag', d.sn, d.imei, s.obs, s.service, s.status, s.data_trimis, s.data_primit, s.checked 
FROM picking_service s 
LEFT JOIN depozite w 
ON s.id_depozit = w.id 
LEFT JOIN picking_devices d 
ON s.id_device = d.id 
WHERE s.status = 'SERVICE' 
OR s.status = 'PENDING' 
ORDER BY s.id DESC
");

echo json_encode($servicepick);