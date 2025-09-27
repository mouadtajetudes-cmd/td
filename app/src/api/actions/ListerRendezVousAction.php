<?php

namespace toubilib\api\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use toubilib\core\application\ports\api\ServiceRendezVousInterface;

class ListerRendezVousAction
{

private ServiceRendezVousInterface $service_rendez_vous;

public function __construct(ServiceRendezVousInterface $service_rendez_vous)
{
    $this->service_rendez_vous = $service_rendez_vous;
}
public function __invoke(Request $request , Response $response) : Response
{
    $rdvs = $this->service_rendez_vous->ListerRendezVous();
    $response->getBody()->write(json_encode($rdvs));
    return $response->withHeader('Content-Type','application/json');
    
}




}