<?php

namespace App\Form;

use App\Entity\SkidayOptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkidayOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            $skidayOptions = $event->getData();
            $form = $event->getForm();
            if ($skidayOptions and $skidayOptions->transportAllerNonracerPlaceCount > -1) {
                $form->add('transportAllerNonracerPlaceCount',
                    IntegerType::class,[
                        'label' => 'Transport Aller - Nombre de place hors coureur demandées'])
                    ->add('transportAllerAvailablePlaceCount',
                        IntegerType::class,[
                            'label' => 'Transport Aller - Nombre de place offertes en covoiturage']);
            }
            if ($skidayOptions and $skidayOptions->transportRetourNonracerPlaceCount > -1) {
                $form->add('transportRetourNonracerPlaceCount',
                    IntegerType::class,[
                        'label' => 'Transport Retour - Nombre de place hors coureur demandées'])
                    ->add('transportRetourAvailablePlaceCount',
                        IntegerType::class,[
                            'label' => 'Transport Retour - Nombre de place offertes en covoiturage']);
            }
            if ($skidayOptions and $skidayOptions->accomodationNonracerPlaceCount > -1) {
                $form->add('accomodationNonracerPlaceCount',
                    IntegerType::class,[
                        'label' => 'Hébergement - Nombre de place hors coureur demandées']);
            }
            if ($skidayOptions and $skidayOptions->skipassNonracerCount > -1) {
                $form->add('skipassNonracerCount',
                    IntegerType::class,[
                        'label' => 'Jour de ski - Nombre de forfait hors coureur demandés']);
            }
            $form->add('Envoyer', SubmitType::class);
        });



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
            $resolver->setDefaults([
                'data_class' => SkidayOptions::class,
            ]);
    }
}
