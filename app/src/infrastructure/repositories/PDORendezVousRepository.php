<?php

namespace toubilib\infra\repositories;
use Exception;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RendezVousRepositoryInterface;
use toubilib\core\domain\entities\praticien\Praticien;
use toubilib\core\domain\entities\praticien\RendezVous;
use toubilib\core\domain\entities\praticien\Specialite;

class PDORendezVousRepository implements RendezVousRepositoryInterface
{
    private \PDO $pdo;
    private PraticienRepositoryInterface $praticien_interface;

    public function __construct(\PDO $pdo, PraticienRepositoryInterface $praticien_interface){
        $this->pdo = $pdo;
        $this->praticien_interface=$praticien_interface;
    }

    public function getAllRendezVous() : array{
        $stmt = $this->pdo->prepare( "SELECT r.id, r.praticien_id, r.patient_id, r.patient_email, r.date_heure_debut,
        r.status, r.duree, r.date_heure_fin, r.date_creation, r.motif_visite
         from rdv r");
         $stmt->execute();
         $results=$stmt->fetchAll(\PDO::FETCH_ASSOC);
         $rdvs = [];
         foreach($results as $rt){
         
      try {
            $pdopraticien = $this->praticien_interface->findPraticienId($rt['praticien_id']);
           
        } catch (Exception $e) {
            $pdopraticien = new Praticien(
                '', 
                '', 
                '', 
                '', 
                '', 
                new Specialite('','','')
            );
        }

            $rdvs[] = new RendezVous(
                $rt['id'],
                $pdopraticien,
                $rt['patient_id'],
                $rt['patient_email']?? ' ',
                $rt['date_heure_debut'],
                $rt['status'],
                $rt['duree'],
                $rt['date_heure_fin'],
                $rt['date_creation'],
                $rt['motif_visite']);
         }
         return $rdvs;

    }
    public function GetRdvsbyPrat(string $pid):array{

        $stmt = $this->pdo->prepare( "SELECT r.id, r.praticien_id, r.patient_id, r.patient_email, r.date_heure_debut,
        r.status, r.duree, r.date_heure_fin, r.date_creation, r.motif_visite
         from rdv r where r.praticien_id = :pid");
         $stmt->execute(["pid"=>$pid]);
         $results=$stmt->fetchAll(\PDO::FETCH_ASSOC);
         
         $rdvs = [];
         foreach($results as $rt){
            $pdopraticien = $this->praticien_interface->findPraticienId($rt['praticien_id']);
                $rdvs[] = new RendezVous(
                $rt['id'],
                $pdopraticien,
                $rt['patient_id'],
                $rt['patient_email']?? ' ',
                $rt['date_heure_debut'],
                $rt['status'],
                $rt['duree'],
                $rt['date_heure_fin'],
                $rt['date_creation'],
                $rt['motif_visite']);

         }
         return $rdvs;
    }

}