<?php

namespace App\Form;

use App\Entity\CsPlayers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CsPlayersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('isActive')
            ->add('ip')
            ->add('lastip')
            ->add('lasttime')
            ->add('country')
            ->add('onlinetime')
            ->add('steamId')
            ->add('amxxFlags')
            ->add('flags')
            ->add('icq')
            ->add('steamId64')
            ->add('role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CsPlayers::class,
        ]);
    }
}
