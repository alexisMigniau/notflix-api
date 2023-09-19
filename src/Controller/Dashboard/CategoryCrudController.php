<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends TimestampCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge([
            IdField::new('id')->setFormTypeOption('disabled','disabled')->setColumns(3),
            TextField::new('label')->setColumns(3),
            FormField::addPanel('Utilisation'),
            AssociationField::new('movies')->autocomplete()->setCrudController(MovieCrudController::class),
            AssociationField::new('series')->autocomplete()->setCrudController(SerieCrudController::class),
        ], parent::configureFields($pageName));
    }
}
