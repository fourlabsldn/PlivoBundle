<?php

namespace FL\PlivoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SmsOutgoingFormType
 * @package FL\PlivoBundle\Form\Type
 */
class SmsOutgoingFormType extends AbstractType
{
    /**
     * @var string
     */
    private $smsClass;

    /**
     * SmsOutgoingFormType constructor.
     * @param string $smsClass
     */
    public function __construct(string $smsClass)
    {
        $this->smsClass = $smsClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', Type\TextType::class, [
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
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->smsClass,
        ]);
    }
}
