<?php
session_start();

// Ruta donde PHP guarda las sesiones
$sessions_path = ini_get('session.save_path');
if (!$sessions_path) {
    $sessions_path = sys_get_temp_dir();
}

$session_count = 0;
if ($handle = opendir($sessions_path)) {
    while (false !== ($file = readdir($handle))) {
        if (strpos($file, 'sess_') === 0) {
            $session_count++;
        }
    }
    closedir($handle);
}
echo $session_count; 