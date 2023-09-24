<?php

namespace App\Controller\Dashboard;

use App\Entity\Season;
use App\Entity\Serie;
use DateTime;
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
            ImageField::new('image')->setBasePath('/uploads/movies/images')->onlyOnIndex(),
            NumberField::new('age_restriction'),
            NumberField::new('seasonCount')->setLabel('Number of seasons')->onlyOnIndex()
        ], parent::configureFields($pageName), [
            FormField::addTab('Seasons'),
            CollectionField::new('seasons')->renderExpanded()->useEntryCrudForm()->onlyOnForms()
        ]);
    }
}
