<?php

namespace toubilib\core\application\ports\api;

interface ServiceRendezVousInterface
{
    public function ListerRendezVous(): array;
    public function ListerRDVID(string $pid): array;
    public function creerRendezVous(InputRendezVousDTO $dto): RendezVousDTO;
    public function annulerRendezVous(string $idRdv): void;
    public function consulterAgenda(string $praticienId, string $dateDebut, string $dateFin): array;
}