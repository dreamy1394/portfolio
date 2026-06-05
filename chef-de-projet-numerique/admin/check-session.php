<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

checkSessionTimeout();
echo json_encode(['status' => 'ok']);
