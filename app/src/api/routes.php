<?php
declare(strict_types=1);

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


    $app->get('/praticiens', ListerPraticiensAction::class);
    // $app->get('/praticiens/{nom}', ListerPraticienAction::class);
    $app->get('/praticiens/{id}', ListerPraticienIdAction::class);


    $app->get('/rdvs', ListerRendezVousAction::class);
    $app->get('/praticiens/{id}/rdvs', ListerRendezVousActionID::class);
    

    $app->post('/rdvs', CreerRendezVousAction::class)
        ->add(ValidationRendezVousMiddleware::class);
    

    $app->patch('/rdvs/{id}/annuler', AnnulerRendezVousAction::class);
    
    // /agenda?date_debut=2025-09-29&date_fin=2025-09-30
    $app->get('/paticiens/{id}/agenda', ConsulterAgendaAction::class);

    return $app;
};