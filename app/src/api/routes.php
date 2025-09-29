<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use toubilib\api\actions\AnnulerRendezVousAction;
use toubilib\api\actions\ConsulterAgendaAction;
use toubilib\api\actions\CreerRendezVousAction;
use toubilib\api\actions\ListerPraticienAction;
use toubilib\api\actions\ListerPraticienIdAction;
use toubilib\api\actions\ListerPraticiensAction;
use toubilib\api\actions\ListerRendezVousAction;
use toubilib\api\actions\ListerRendezVousActionID;
use toubilib\api\middlewares\ValidationRendezVousMiddleware;

return function(\Slim\App $app): \Slim\App {


    $app->get('/', ListerPraticiensAction::class);
    $app->get('/prat/{nom}', ListerPraticienAction::class);
    $app->get('/prat/id/{id}', ListerPraticienIdAction::class);


    $app->get('/rdvs', ListerRendezVousAction::class);
    $app->get('/rdvs/id/{id}', ListerRendezVousActionID::class);
    

    $app->post('/rdvs', CreerRendezVousAction::class)
        ->add(ValidationRendezVousMiddleware::class);
    

    $app->patch('/rdvs/{id}/annuler', AnnulerRendezVousAction::class);
    
    // /agenda?date_debut=2025-09-29&date_fin=2025-09-30
    $app->get('/prat/id/{id}/agenda', ConsulterAgendaAction::class);

    return $app;
};