<?php
namespace toubilib\infra\repositories;

use PDO;
use toubilib\core\application\ports\spi\repositoryInterfaces\UserRepositoryInterface;
use toubilib\core\domain\entities\auth\User;

class UserRepository implements UserRepositoryInterface{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo=$pdo;
    }
    public function FindById(string $id): ?User
    {
        $stmt = $this->pdo->prepare("
        SELECT id,email,password,role FROM users where id = :id");
        $stmt->execute([":id"=>$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return null;
        }
        else{
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['role']
            );
        }
    }
    public function FindByEmail(string $email): ?User
    {
               $stmt = $this->pdo->prepare("
        SELECT id,email,password,role FROM users where email = :email");
        $stmt->execute([":email"=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return null;
        }
        else{
            return new User(
                $row['id'],
                $row['email'],
                $row['password'],
                $row['role']
            );
        } 
    }
}