<?php

$dbConfig = parse_ini_file(__DIR__ . '/praticien.ini', true)['database'];

return [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => $dbConfig,
    ],
];
