<?php

namespace App\Controller\Dashboard;

use App\Entity\Episode;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EpisodeCrudController extends TimestampCrudController
{
    public static function getEntityFqcn(): string
    {
        return Episode::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setColumns(12),
            TextareaField::new('description')->onlyOnForms()->setColumns(12),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            TextField::new('image')->setLabel('Image URL')->onlyOnForms(),
            ImageField::new('image')->setBasePath('/uploads/episodes/images')->onlyOnIndex()
        ];
    }
}
