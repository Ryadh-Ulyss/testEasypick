<?php

namespace App\Form;

use App\Entity\Company;
use Attribute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'constraints' => new Length(['min' => "2"]),
                'required' => true,
                'attr'=>[
                    'placeholder' => "Entreprise"
                ]
            ])
            ->add('siren', TextType::class, [
                'label' => 'Siren',
                'constraints' => new Length(['min' => "2"]),
                'required' => true,
                'attr'=>[
                    'placeholder' => "Ex: 362 521 879"
                ]
            ])
            ->add('activityArea', TextType::class, [
                'label' => 'Secteur d\'activité',
                'constraints' => new Length(['min' => "2", 'max' => "100"]),
                'required' => true,
                'attr'=>[
                    'placeholder' => "Ex: Banque, Assurance, BTP, "
                ]
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse',
                'required' => true,
                'attr'=>[
                    'placeholder' => "Adresse"
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'constraints' => new Length(['min' => "2", 'max' => "15"]),
                'required' => true,
                'attr'=>[
                    'placeholder' => "Cp"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => new Length(['min' => "2", 'max' => "15"]),
                'required' => true,
                'attr'=>[
                    'placeholder' => "Ville"
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => "Pays",
                'preferred_choices' => ['FR']
            ])
            ->add('employeesNumb', IntegerType::class, [
                'label' => 'Nombre d\'employés',
                'attr' =>[
                    'placeholder' => 'Nombre d\'employés'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
