<?php

use toubilib\core\application\ports\api\AuthnServiceInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\api\ServiceRendezVousInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RendezVousRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\UserRepositoryInterface;
use toubilib\core\application\usecases\AuthnService;
use toubilib\infra\repositories\PDOPraticienRepository;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\core\application\usecases\ServiceRendezVous;
use toubilib\infra\repositories\PDORendezVousRepository;
use toubilib\infra\repositories\UserRepository;

return [
    // Connexion PDO
    'praticien_db' => static function ($c): PDO {
        $dbConfig = $c->get('settings')['db_p'];
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
    'rdv_db' => static function ($c): PDO {
        $dbrConfig = $c->get('settings')['db_rdv'];
        $driver  = $dbrConfig['driver'] ?? 'pgsql';
        $host    = $dbrConfig['host'] ?? 'localhost';
        $dbname  = $dbrConfig['dbname'] ?? 'toubiprat';
        $user    = $dbrConfig['username'] ?? 'toubiprat';
        $pass    = $dbrConfig['password'] ?? 'toubiprat';
        $charset = $dbrConfig['charset'] ?? 'utf8mb4';

        $dsn = $driver === 'mysql'
            ? "mysql:host={$host};dbname={$dbname};charset={$charset}"
            : "pgsql:host={$host};dbname={$dbname}";

        return new PDO($dsn, $user, $pass);
    },
    'toubiauth_db' => static function ($c): PDO {
        $dbaConfig = $c->get('settings')['db_auth'];
        $driver  = $dbaConfig['driver'] ?? 'pgsql';
        $host    = $dbaConfig['host'] ?? 'localhost';
        $dbname  = $dbaConfig['dbname'] ?? 'toubiauth';
        $user    = $dbaConfig['username'] ?? 'toubiauth';
        $pass    = $dbaConfig['password'] ?? 'toubiauth';
        $charset = $dbaConfig['charset'] ?? 'utf8mb4';

        $dsn = $driver === 'mysql'
            ? "mysql:host={$host};dbname={$dbname};charset={$charset}"
            : "pgsql:host={$host};dbname={$dbname}";

        return new PDO($dsn, $user, $pass);
    },
    

    // Repository
    PraticienRepositoryInterface::class =>  function ($c) {
        return new PDOPraticienRepository($c->get('praticien_db'));
    },
    RendezVousRepositoryInterface::class =>  function ($a){
        return new PDORendezVousRepository(
            $a->get('rdv_db'),
            $a->get(PraticienRepositoryInterface::class)
        );
    },
        UserRepositoryInterface::class => function ($c) {
        return new UserRepository($c->get('toubiauth_db'));
    },
    

    ServicePraticienInterface::class =>  function ($c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },
    ServiceRendezVousInterface::class =>  function ($c) {
        return new ServiceRendezVous(
            $c->get(RendezVousRepositoryInterface::class),
            $c->get(PraticienRepositoryInterface::class) 
        );
    },
        AuthnServiceInterface::class => function ($c) {
        return new AuthnService(
            $c->get(UserRepositoryInterface::class)
        );
    },
];