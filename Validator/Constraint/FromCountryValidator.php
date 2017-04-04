<?php

namespace FL\PlivoBundle\Validator\Constraint;

use libphonenumber\PhoneNumberUtil;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class FromCountryValidator extends ConstraintValidator
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneNumberUtil;

    public function __construct(PhoneNumberUtil $phoneNumberUtil)
    {
        $this->phoneNumberUtil = $phoneNumberUtil;
    }

    public function validate($object, Constraint $constraint)
    {
        /** @var FromCountry $constraint */
        if (null !== $constraint->errorPath && !is_string($constraint->errorPath)) {
            throw new UnexpectedTypeException($constraint->errorPath, 'string or null');
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        if (!$accessor->isReadable($object, $constraint->fromField)) {
            throw new ConstraintDefinitionException(sprintf(
                'The field "%s" is not readable, so it cannot be used for validation.',
                $constraint->fromField
            ));
        }

        if (!$accessor->isReadable($object, $constraint->toField)) {
            throw new ConstraintDefinitionException(sprintf(
                'The field "%s" is not readable, so it cannot be used for validation.',
                $constraint->toField
            ));
        }

        $fromPhone = $this->phoneNumberUtil->parse($accessor->getValue($object, $constraint->fromField), 'GB');
        $fromCountryCode = $this->phoneNumberUtil->getRegionCodeForNumber($fromPhone);

        $toValue = $accessor->getValue($object, $constraint->toField);

        if (!is_array($toValue)) {
            $toValue = [$toValue];
        }

        foreach ($toValue as $toNumber) {
            $toPhone = $this->phoneNumberUtil->parse($toNumber, 'GB');
            $toCountryCode = $this->phoneNumberUtil->getRegionCodeForNumber($toPhone);

            if (!($toCountryCode === 'US' || $toCountryCode === 'CA')) {
                continue;
            }

            if ($fromCountryCode === $toCountryCode) {
                continue;
            }

            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ number }}', $this->formatValue($toNumber))
                ->atPath($constraint->errorPath)
                ->addViolation();
        }
    }
}
