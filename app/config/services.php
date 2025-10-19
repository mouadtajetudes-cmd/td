<?php

use toubilib\api\middlewares\AuthzPatientMiddleware;
use toubilib\api\middlewares\AuthzPraticienMiddleware;
use toubilib\api\middlewares\AuthzRendezVousMiddleware;
use toubilib\api\middlewares\CorsMiddleware;
use toubilib\api\provider\AuthProviderInterface;
use toubilib\api\provider\jwt\JwtAuthProvider;
use toubilib\api\provider\jwt\JwtManager;
use toubilib\api\provider\jwt\JwtManagerInterface;
use toubilib\core\application\ports\api\AuthnServiceInterface;
use toubilib\core\application\ports\api\AuthzPatientServiceInterface;
use toubilib\core\application\ports\api\AuthzPraticienServiceInterface;
use toubilib\core\application\ports\api\AuthzRDVServiceInterface;
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
    
    // Repositories
    PraticienRepositoryInterface::class => function ($c) {
        return new PDOPraticienRepository($c->get('praticien_db'));
    },
    
    RendezVousRepositoryInterface::class => function ($a) {
        return new PDORendezVousRepository(
            $a->get('rdv_db'),
            $a->get(PraticienRepositoryInterface::class)
        );
    },
    
    UserRepositoryInterface::class => function ($c) {
        return new UserRepository($c->get('toubiauth_db'));
    },
    
    // JWT
    JwtManagerInterface::class => function () {
        //Pas de valeur par défaut, obligatoire, on peut ni coder ni décoder sans cette clé 
        $jwtSecret = $_ENV['JWT_SECRET'];
        $accessExpiration = 3600; 
        $refreshExpiration = 86400;
        
        $jwtManager = new JwtManager($jwtSecret, $accessExpiration, $refreshExpiration);
        $jwtManager->setIssuer('toubilib');
        
        return $jwtManager;
    },
    
    // Services
    ServicePraticienInterface::class => function ($c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },
    
    ServiceRendezVousInterface::class => function ($c) {
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
    
    // Auth Provider
    AuthProviderInterface::class => function ($c) {
        return new JwtAuthProvider(
            $c->get(AuthnServiceInterface::class),
            $c->get(JwtManagerInterface::class)
        );
    },

    // Services d'autorisation
    AuthzPraticienServiceInterface::class => function ($c) {
        return new AuthzPraticienServiceInterface(
            $c->get(PraticienRepositoryInterface::class)
        );
    },
    
    AuthzPatientServiceInterface::class => function ($c) {
        return new AuthzPatientServiceInterface();
    },
    
    AuthzRDVServiceInterface::class => function ($c) {
        return new AuthzRDVServiceInterface(
            $c->get(RendezVousRepositoryInterface::class)
        );
    },
    
    // Middlewares d'autorisation
    AuthzPraticienMiddleware::class => function ($c) {
        return new AuthzPraticienMiddleware(
            $c->get(AuthzPraticienServiceInterface::class)
        );
    },
    
    AuthzPatientMiddleware::class => function ($c) {
        return new AuthzPatientMiddleware(
            $c->get(AuthzPatientServiceInterface::class)
        );
    },
    
    AuthzRendezVousMiddleware::class => function ($c) {
        return new AuthzRendezVousMiddleware(
            $c->get(AuthzRDVServiceInterface::class)
        );
    },
    
    // Middleware CORS
    CorsMiddleware::class => function ($c) {
        return new CorsMiddleware();
    },
];