<?php

use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\infra\repositories\PDOPraticienRepository;
use toubilib\core\application\usecases\ServicePraticien;

return [
    // Connexion PDO
    'praticien_db' => static function ($c): PDO {
        $dbConfig = $c->get('settings')['db'];
        $driver  = $dbConfig['driver'] ?? 'pgsql';
        $host    = $dbConfig['host'] ?? 'localhost';
        $dbname  = $dbConfig['dbname'] ?? 'toubiprat';
        $user    = $dbConfig['username'] ?? 'toubiprat';
        $pass    = $dbConfig['password'] ?? 'toubiprat';
        $charset = $dbConfig['charset'] ?? 'utf8mb4';

        $dsn = $driver === 'mysql'
            ? "mysql:host={$host};dbname={$dbname};charset={$charset}"
            : "pgsql:host={$host};dbname={$dbname}";

        return new PDO($dsn, $user, $pass);
    },

    // Repository
    PraticienRepositoryInterface::class => static function ($c) {
        return new PDOPraticienRepository($c->get('praticien_db'));
    },

    // Service
    ServicePraticienInterface::class => static function ($c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },
];
