<?php

namespace App\Form;

use App\Entity\Difficulty;
use App\Entity\Hike;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('Content')
            ->add('length')
            ->add('duration')
            ->add('elevation_gain')
            ->add('elevation_loss')
            ->add('gps_coordonate')

            ->add('difficulty', EntityType::class, [
                'class' => Difficulty::class,
                'expanded' => true,
                'choice_label' => 'level'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hike::class,
        ]);
    }
}
