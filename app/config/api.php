<?php

use toubilib\api\actions\AnnulerRendezVousAction;
use toubilib\api\actions\ConsulterAgendaAction;
use toubilib\api\actions\ConsulterRendezVousAction;
use toubilib\api\actions\CreerRendezVousAction;
use toubilib\api\actions\HonorerRendezVousAction;
use toubilib\api\actions\ListerPraticienAction;
use toubilib\api\actions\ListerPraticienIdAction;
use toubilib\api\actions\ListerPraticiensAction;
use toubilib\api\actions\ListerRendezVousAction;
use toubilib\api\actions\ListerRendezVousActionID;
use toubilib\api\actions\NePasHonorerRendezVousAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\api\ServiceRendezVousInterface;
use toubilib\api\actions\SigninAction;
use toubilib\api\actions\RefreshTokenAction;
use toubilib\api\provider\AuthProviderInterface;

return [
    ListerPraticiensAction::class => function ($c) {
        return new ListerPraticiensAction(
            $c->get(ServicePraticienInterface::class)
        );
    },
    
    ListerPraticienAction::class => function ($c) {
        return new ListerPraticienAction( 
            $c->get(ServicePraticienInterface::class)
        );
    },
    
    ListerPraticienIdAction::class => function ($c) {
        return new ListerPraticienIdAction( 
            $c->get(ServicePraticienInterface::class)
        );
    },
    
    ListerRendezVousAction::class => function ($c) {
        return new ListerRendezVousAction(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
    
    ListerRendezVousActionID::class => function ($c) {
        return new ListerRendezVousActionID(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
    
    CreerRendezVousAction::class => function ($c) {
        return new CreerRendezVousAction(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
    
    AnnulerRendezVousAction::class => function ($c) {
        return new AnnulerRendezVousAction(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
    
    ConsulterAgendaAction::class => function ($c) {
        return new ConsulterAgendaAction(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
    
    SigninAction::class => function ($c) {
        return new SigninAction(
            $c->get(AuthProviderInterface::class)
        );
    },
    
    RefreshTokenAction::class => function ($c) {
        return new RefreshTokenAction(
            $c->get(AuthProviderInterface::class)
        );
    },
    ConsulterRendezVousAction::class => function ($c) {
        return new ConsulterRendezVousAction(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
    HonorerRendezVousAction::class => function ($c) {
        return new HonorerRendezVousAction(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
    NePasHonorerRendezVousAction::class => function ($c) {
        return new NePasHonorerRendezVousAction(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
];