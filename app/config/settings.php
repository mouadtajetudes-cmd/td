<?php

$dbConfig = parse_ini_file(__DIR__ . '/praticien.ini', true)['database'];
$dbrConfig = parse_ini_file(__DIR__ . '/rdv.ini', true)['database'];

return [
    'settings' => [
        'displayErrorDetails' => true,
        'db_p' => $dbConfig,
        'db_rdv' => $dbrConfig,
    ],
];
