<?php
$dirPath = storage_path('framework/settings/app.php');
if(file_exists($dirPath)) {
    require $dirPath;
    return $settings;
}
?>