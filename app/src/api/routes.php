<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use toubilib\api\actions\ListerPraticienAction;
use toubilib\api\actions\ListerPraticienIdAction;
use toubilib\api\actions\ListerPraticiensAction;
use toubilib\api\actions\ListerRendezVousAction;
use toubilib\api\actions\ListerRendezVousActionID;

return function( \Slim\App $app):\Slim\App {

    $app->get('/', ListerPraticiensAction::class);
    $app->get('/prat/{nom}', ListerPraticienAction::class);
    $app->get('/prat/id/{id}', ListerPraticienIdAction::class);
    $app->get('/rdvs', ListerRendezVousAction::class);
    $app->get('/rdvs/id/{id}', ListerRendezVousActionID::class);

    return $app;
};