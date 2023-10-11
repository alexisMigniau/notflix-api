<?php

namespace App\Controller\Dashboard;

use App\Entity\Season;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeasonCrudController extends TimestampCrudController
{
    public static function getEntityFqcn(): string
    {
        return Season::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Seasons informations'),
            TextField::new('name')->setColumns(12),
            DateField::new('publication_date')->setColumns(12),
            FormField::addTab('Episodes')->setColumns(12),
            CollectionField::new('episodes')->renderExpanded()->useEntryCrudForm()->onlyOnForms()->setColumns(12)
        ];
    }
}
