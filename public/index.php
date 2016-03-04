<?php

error_reporting(E_ALL);

try {
    include __DIR__.'/../app/config/appload.php';
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
