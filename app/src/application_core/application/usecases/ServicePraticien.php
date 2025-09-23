<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\ports\api\PraticienDTO;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function ListerPraticiens(): array {
        $praticiensrepos = $this->praticienRepository->GetAllPraticiens();
        $praticiens = [];
        foreach ($praticiensrepos as $prep){
            $praticiens [] = new PraticienDTO(
                $prep->getId(),
                $prep->getNom(),
                $prep->getPrenom(),
                $prep->getVille(),
                $prep->getEmail(),
                $prep->getSpecialite()->getLibelle(),
                $prep->getSpecialite()->getDescription()
            );
        }
        return $praticiens;
    	
    }
    public function ListerPraticien(string $nom) : array{
         $prep = $this->praticienRepository->findPraticien($nom);
        $praticienDTO = [];
         $praticienDTO [] = new PraticienDTO(
                 $prep->getId(),
                $prep->getNom(),
                $prep->getPrenom(),
                $prep->getVille(),
                $prep->getEmail(),
                $prep->getSpecialite()->getLibelle(),
                $prep->getSpecialite()->getDescription()
         );
         return $praticienDTO;
    }
}