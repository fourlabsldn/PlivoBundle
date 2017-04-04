<?php

namespace FL\PlivoBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * You can send SMS text messages to any country set any ‘src’ number except for US and Canadian numbers.
 * In order to send text messages to phones in the US or Canada, you will need to purchase a US or
 * Canadian phone number from Plivo and use it as the ‘src’ number.
 *
 * @Annotation
 */
class FromCountry extends Constraint
{
    public $message = 'Messages to {{ number }} cannot use this sender';

    public $fromField;

    public $toField;

    public $errorPath;

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function getRequiredOptions()
    {
        return ['fromField', 'toField'];
    }
}
