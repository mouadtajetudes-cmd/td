<?php

use toubilib\api\actions\ListerPraticienAction;
use toubilib\api\actions\ListerPraticiensAction;
use toubilib\api\actions\ListerRendezVousAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\api\ServiceRendezVousInterface;

return [
    ListerPraticiensAction::class => static function ($c) {
        return new ListerPraticiensAction(
            $c->get(ServicePraticienInterface::class)
        );
    },
    ListerPraticienAction::class => static function ($c){
        return new ListerPraticienAction( 
            $c->get(ServicePraticienInterface::class)
        );
    },
        ListerRendezVousAction::class => static function ($c) {
        return new ListerRendezVousAction(
            $c->get(ServiceRendezVousInterface::class)
        );
    },
];
