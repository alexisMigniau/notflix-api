<?php

namespace App\Controller\Dashboard;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

abstract class TimestampCrudController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addRow(),
            DateTimeField::new('createdAt')->hideWhenCreating()->setFormTypeOption('disabled','disabled'),
            DateTimeField::new('updatedAt')->hideWhenCreating()->setFormTypeOption('disabled','disabled')
        ];
    }
}
