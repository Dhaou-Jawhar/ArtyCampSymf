<?php

namespace App\Form;
use App\Entity\Artvip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use App\Entity\Classroom;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class rechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('artnom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artvip::class,
        ]);
    }
}
