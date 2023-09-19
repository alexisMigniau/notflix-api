<?php

namespace App\Controller\Dashboard;

use App\Entity\Serie;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SerieCrudController extends TimestampCrudController
{
    public static function getEntityFqcn(): string
    {
        return Serie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge([
            IdField::new('id')->setFormTypeOption('disabled','disabled'),
            TextField::new('slug')->onlyWhenUpdating(),
            TextField::new('name'),
            AssociationField::new('categories')->autocomplete()->setCrudController(CategoryCrudController::class),
            TextareaField::new('description')->onlyOnForms(),
            NumberField::new('age_restriction')
        ], parent::configureFields($pageName));
    }
}
