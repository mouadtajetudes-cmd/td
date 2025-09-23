<?php


use toubilib\api\actions\ListerPraticiensAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\infra\repositories\PDOPraticienRepository;

$dbConfig = parse_ini_file(__DIR__ . '/praticien.ini', true);
return [
        'settings' => [
        'displayErrorDetails' => true,
        'toubiprati.db' => $dbConfig, 
    ],
    'praticien_db' => static function () use ($dbConfig): PDO {
        $driver = $dbConfig['driver'] ?? 'pgsql';
        $host = $dbConfig['host'] ?? 'toubiprati.db';
        $db = $dbConfig['database'] ?? 'toubiprat' ;
        $user = $dbConfig['username'] ?? 'toubiprat';
        $pass = $dbConfig['password'] ?? 'toubiprat';
        $charset = 'utf8mb4';

        $dsn = $driver === 'mysql'
            ? "mysql:host={$host};dbname={$db};charset={$charset}"
            : "pgsql:host={$host};dbname={$db}";

        return new PDO($dsn, $user, $pass);
    },

    PraticienRepositoryInterface::class => static function ($c) {
        return new PDOPraticienRepository(
            $c->get('praticien_db'),
        );
    },

    ServicePraticienInterface::class => static function ($c) {
        return new ServicePraticien(
            $c->get(PraticienRepositoryInterface::class)
        );
    },

    ListerPraticiensAction::class => static function ($c) {
        return new ListerPraticiensAction(
            $c->get(ServicePraticienInterface::class)
        );
    },

];