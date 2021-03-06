<?php

namespace FL\PlivoBundle\Form\Type;

use Plivo\DataTransformer\BulkSmsFormTransformer;
use Plivo\Model\BulkSmsOutgoing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BulkSmsOutgoingFormType.
 */
class BulkSmsOutgoingFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', FromType::class, [
                'required' => true,
                'label' => 'From',
            ])
            ->add('to', Type\TextType::class, [
                'required' => true,
                'label' => 'To',
            ])
            ->add('text', Type\TextareaType::class, [
                'required' => true,
                'label' => 'Text',
            ])
        ;

        $builder->get('to')->addModelTransformer(new BulkSmsFormTransformer());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BulkSmsOutgoing::class,
        ]);
    }
}
