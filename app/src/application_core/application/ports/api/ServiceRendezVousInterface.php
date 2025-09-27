<?php

namespace toubilib\core\application\ports\api;

interface ServiceRendezVousInterface{
    public function ListerRendezVous() : array;
    public function ListerRDVID(string $pid) : array;
}