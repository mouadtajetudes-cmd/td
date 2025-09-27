<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\ports\api\RendezVousDTO;
use toubilib\core\application\ports\api\RendezVousDTOID;
use toubilib\core\application\ports\api\ServiceRendezVousInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RendezVousRepositoryInterface;

class ServiceRendezVous implements ServiceRendezVousInterface{

    private RendezVousRepositoryInterface $rendezVousRepository;
    public function __construct(RendezVousRepositoryInterface $rendezVousRepository)
    {
        $this->rendezVousRepository=$rendezVousRepository;
    }
    public function ListerRendezVous() : array
    {
        $lien = "http://localhost:6080/prat/id";
        $rdvs = $this->rendezVousRepository->getAllRendezVous();
        $rdv = [];
        foreach($rdvs as $element){
            $rdv[] = new RendezVousDTO(
                $element->getId(),
                $element->getPraticien()->getNom(),
                $lien . "/" . $element->getPraticien()->getId(),  
                $element->getPatientId(),
                $element->getPatientEmail(),
                $element->getStatus(),
                $element->getDuree(),
                $element->getDateHF(),
                $element->getDateC(),
                $element->getMotifVisite()
            );
        }
        return $rdv;
    }
    public function ListerRDVID(string $pid): array
    {
         $rdvs = $this->rendezVousRepository->GetRdvsbyPrat($pid);
        $rdv = [];
        foreach($rdvs as $element){
           
            $rdv[] = new RendezVousDTOID(
                $element->getId(),
                $element->getPraticien()->getId(),
                $element->getPatientId(),
                $element->getPatientEmail(),
                $element->getStatus(),
                $element->getDuree(),
                $element->getDateHF(),
                $element->getDateC(),
                $element->getMotifVisite()
            );
        }
   
        return $rdv;
    }
    



}