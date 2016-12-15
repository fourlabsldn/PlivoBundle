<?php

namespace FL\PlivoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FromType extends AbstractType
{
    /**
     * @var string[]
     */
    protected $phoneNumberChoices;

    /**
     * @param array $phoneNumbers
     */
    public function __construct(array $phoneNumbers)
    {
        $this->phoneNumberChoices = array_combine($phoneNumbers, $phoneNumbers);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('choices', $this->phoneNumberChoices);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}
