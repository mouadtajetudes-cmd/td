<?php
namespace toubilib\core\application\ports\api;

interface ServicePraticienInterface{

    public function ListerPraticiens(): array;
    public function ListerPraticien(string $nom): array;
}




