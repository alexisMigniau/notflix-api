<?php

namespace App\Controller\Dashboard;

use App\Entity\Season;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeasonCrudController extends TimestampCrudController
{
    public static function getEntityFqcn(): string
    {
        return Season::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge([
            TextField::new('name')->setColumns(12),
            DateField::new('publication_date')->setColumns(12)
        ], parent::configureFields($pageName));
    }
}
