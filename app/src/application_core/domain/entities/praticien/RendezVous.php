<?php
namespace toubilib\core\domain\entities\praticien;


class RendezVous{
    private string $id;
    private Praticien $praticien;
    // private string $praticien_id;
    private string $patient_id;
    private string $patient_email;
    private string $status;
    private string $duree;
      private string $date_heure_debut;
    private string $date_heure_fin;
    private string $date_creation;
    private string $motif_visite;

    public function __construct(
        string $id,
        // string $praticien_id,
        Praticien $praticien,
        string $patient_id,
        string $patient_email,
        string $date_heure_debut,
        string $status,
        string $duree,
        string $date_heure_fin,
        string $date_creation,
        string $motif_visite
    )
    {
     $this->id=$id;
    //  $this->praticien_id=$praticien_id;
     $this->praticien=$praticien;
     $this->patient_id=$patient_id;
     $this->patient_email=$patient_email;
     $this->status=$status;
     $this->date_heure_debut = $date_heure_debut;
     $this->duree=$duree;
     $this->date_heure_fin=$date_heure_fin;
     $this->date_creation=$date_creation;
     $this->motif_visite=$motif_visite;
    }
public function getId() : string{
    return $this->id;
}
// public function getPraticien() : string{
//     return $this->praticien_id;
// }
public function getPraticien() : Praticien{
    return $this->praticien;
}
public function getPatientId() : string{
    return $this->patient_id;
}
public function getPatientEmail() : string{
    return $this->patient_email;
}
public function getStatus() : string{
    return $this->status;
}
public function getDuree() : string{
    return $this->duree;
}
public function getDateHF() : string{
    return $this->date_heure_fin;
}
  public function getDateHD(): string {
        return $this->date_heure_debut;
    }
public function getDateC() : string{
    return $this->date_creation;
}
public function getMotifVisite() : string{
    return $this->motif_visite;
}
}
