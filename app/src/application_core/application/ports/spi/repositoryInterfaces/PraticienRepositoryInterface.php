<?php
namespace toubilib\core\application\ports\spi\repositoryInterfaces;


interface PraticienRepositoryInterface{

    public function GetAllPraticiens() : array;
}