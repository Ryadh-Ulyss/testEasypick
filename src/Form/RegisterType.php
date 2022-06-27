<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use App\Repository\CompanyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    private $companyRepository;
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => new Length(['min' => "2", 'max' => "15"]),
                'attr'=>[
                    'placeholder' => "Saisissez votre prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'constraints' => new Length(['min' => "2", 'max' => "15"]),
                'attr'=>[
                    'placeholder' => "Saisissez votre nom"
                ]
            ])
            ->add('email', EmailType::class, [
                'label'=> 'Email',
                'attr'=>[
                    'placeholder' => 'Saisissez votre email'
                ]
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
                'choices' => $this->companyRepository->companiesList()
            ])
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Client1' => 'ROLE_USER_ONE',
                    'Client2' => 'ROLE_USER_TWO',
                    'Administrateur' => 'ROLE_ADMIN'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Mot de passe non identique',
                'label' => 'Mot de passe',
                'required' => true,
                'first_options'=> [
                    'label' => "Saisissez votre mot de passe", 
                    'attr' => ['placeholder' => "Mot de passe"]],
                'second_options' => [
                    'label' => "Confirmez le mot de passe", 
                    'attr' => ['placeholder' => "Confirmez le mot de passe"]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter'
            ])
        ;

        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     // transform the array to a string
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     // transform the string back to an array
                     return [$rolesString];
                }
        ));
    }

    public function addElement(FormInterface $form, Company $company = null)
    {
        $form->add('company', EntityType::class, array(
            'required' => true,
            'data' => $company,
            'placeholder' => 'Selectionnez une entreprise'
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
