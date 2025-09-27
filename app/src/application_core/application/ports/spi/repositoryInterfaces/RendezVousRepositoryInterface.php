<?php
namespace toubilib\core\application\ports\spi\repositoryInterfaces;

interface RendezVousRepositoryInterface{
    public function getAllRendezVous() : array ;
    public function GetRdvsbyPrat(string $pid) : array ;
    
}