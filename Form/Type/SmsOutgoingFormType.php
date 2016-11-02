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
     * @var string[]|int[]
     */
    private $phoneNumberChoices;

    /**
     * SmsOutgoingFormType constructor.
     * @param string $smsClass
     * @param \int[]|\string[] $phoneNumbers
     */
    public function __construct(string $smsClass, array $phoneNumbers)
    {
        $this->smsClass = $smsClass;
        $this->phoneNumberChoices = array_combine($phoneNumbers, $phoneNumbers);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', Type\ChoiceType::class, [
                'required' => true,
                'label' => 'From',
                'choices' => $this->phoneNumberChoices
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
