<?php

namespace App\Controller\Dashboard;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MovieCrudController extends TimestampCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge([
            IdField::new('id')->setFormTypeOption('disabled','disabled'),
            TextField::new('slug')->onlyWhenUpdating(),
            TextField::new('name'),
            AssociationField::new('categories')->autocomplete()->setCrudController(CategoryCrudController::class),
            TextareaField::new('description')->onlyOnForms(),
            NumberField::new('age_restriction'),
            DateField::new('publication_date')
        ], parent::configureFields($pageName));
    }
}
