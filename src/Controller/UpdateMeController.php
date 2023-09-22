<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UpdateMeController extends AbstractController
{
    public function __invoke(User $data): User
    {
        $current_user = $this->getUser();
        $current_user->setEmail($data->getEmail());
        $current_user->setPlainPassword($data->getPlainPassword());

        return $current_user;
    }
}
