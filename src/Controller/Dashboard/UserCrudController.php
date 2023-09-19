<?php

namespace App\Controller\Dashboard;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Action, Actions, Crud, KeyValueStore};
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\{ChoiceField, DateTimeField, IdField, EmailField, TextField};
use Symfony\Component\Form\Extension\Core\Type\{PasswordType};
use Symfony\Component\Form\{FormBuilderInterface, FormEvent, FormEvents};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private $userPasswordHasher;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher
    ) {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            ChoiceField::new('roles')
                ->allowMultipleChoices()
                ->renderAsBadges([
                    'ROLE_ADMIN' => 'primary',
                    'ROLE_USER' => 'secondary',
                ])->setChoices([
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER'
                ])->renderExpanded(),
            TextField::new('plainPassword', 'Password')->setFormType(PasswordType::class)
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            DateTimeField::new('updatedAt')->onlyOnIndex(),
        ];
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface
    {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    private function hashPassword() {
        return function($event) {
            $form = $event->getForm();
            if (!$form->isValid()) {
                return;
            }
            $password = $form->get('plainPassword')->getData();
            if ($password === null) {
                return;
            }

            $hash = $this->userPasswordHasher->hashPassword($form->getData(), $password);
            $form->getData()->setPassword($hash);
            $form->getData()->eraseCredentials();
        };
    }
}
