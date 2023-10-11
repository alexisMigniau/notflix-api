<?php

namespace App\Controller\Dashboard;

use App\Entity\Serie;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SerieCrudController extends TimestampCrudController
{
    public static function getEntityFqcn(): string
    {
        return Serie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array_merge([
            FormField::addTab('Series informations'),
            IdField::new('id')->setFormTypeOption('disabled','disabled')->setColumns(1),
            TextField::new('slug')->onlyWhenUpdating()->setColumns(3),
            TextField::new('name')->setColumns(3),
            AssociationField::new('categories')->autocomplete()->setCrudController(CategoryCrudController::class)->setColumns(7),
            TextareaField::new('description')->onlyOnForms()->setColumns(12),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            TextField::new('image')->setLabel('Image URL')->onlyOnForms(),
            ImageField::new('image')->setBasePath('/uploads/series/images')->onlyOnIndex(),
            NumberField::new('age_restriction'),
            NumberField::new('seasonCount')->setLabel('Number of seasons')->onlyOnIndex(),
            NumberField::new('episodeCount')->setLabel('Number of episodes')->onlyOnIndex()
        ], parent::configureFields($pageName), [
            FormField::addTab('Seasons')->setColumns(12),
            CollectionField::new('seasons')->renderExpanded()->useEntryCrudForm()->onlyOnForms()->setColumns(12)
        ]);
    }
}
