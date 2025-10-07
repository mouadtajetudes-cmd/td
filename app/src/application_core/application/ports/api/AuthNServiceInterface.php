<?php

namespace toubilib\core\application\ports\api;

interface AuthNServiceInterface
{
    public function byCredentials(string $email, string $password) : UserProfileDTO;
}
?>