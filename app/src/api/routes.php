<?php
declare(strict_types=1);

use toubilib\api\actions\AnnulerRendezVousAction;
use toubilib\api\actions\ConsulterAgendaAction;
use toubilib\api\actions\ConsulterRendezVousAction;
use toubilib\api\actions\CreerRendezVousAction;
use toubilib\api\actions\HonorerRendezVousAction;
use toubilib\api\actions\ListerPraticienIdAction;
use toubilib\api\actions\ListerPraticiensAction;
use toubilib\api\actions\ListerRendezVousAction;
use toubilib\api\actions\ListerRendezVousActionID;  
use toubilib\api\actions\NePasHonorerRendezVousAction;
use toubilib\api\middlewares\ValidationRendezVousMiddleware;

return function(\Slim\App $app): \Slim\App {
    
    // Praticiens
    $app->get('/praticiens', ListerPraticiensAction::class);
    $app->get('/praticiens/{id}', ListerPraticienIdAction::class);
    $app->get('/praticiens/{id}/agenda', ConsulterAgendaAction::class);

    
    // Rdvs
    $app->get('/rdvs', ListerRendezVousAction::class);
    
    $app->get('/rdvs/{id}', ConsulterRendezVousAction::class);
    
    $app->get('/praticiens/{id}/rdvs', ListerRendezVousActionID::class);  
    
    $app->post('/rdvs', CreerRendezVousAction::class)
        ->add(ValidationRendezVousMiddleware::class);
    
    $app->patch('/rdvs/{id}/annuler', AnnulerRendezVousAction::class);
    $app->patch('/rdvs/{id}/honorer', HonorerRendezVousAction::class);
    $app->patch('/rdvs/{id}/ne-pas-honorer', NePasHonorerRendezVousAction::class);
    
    
    return $app;
};