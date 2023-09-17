<?php

namespace App\Controller\Dashboard;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('email'),
            TextField::new('plainPassword', 'Password')->onlyOnForms(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            DateTimeField::new('updatedAt')->onlyOnIndex(),
            ChoiceField::new('roles')->allowMultipleChoices()->renderAsBadges([
                'ROLE_ADMIN' => 'primary',
                'ROLE_USER' => 'secondary',
            ])->setChoices([
                'Admin' => 'ROLE_ADMIN',
                'User' => 'ROLE_USER'
            ])->renderExpanded()
        ];
    }
}
