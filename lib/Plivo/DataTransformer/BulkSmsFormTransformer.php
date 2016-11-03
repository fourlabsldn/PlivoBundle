<?php

namespace Plivo\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class BulkSmsTransformer.
 */
class BulkSmsFormTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $to
     *
     * @return string
     */
    public function transform($to): string
    {
        return $to ? implode(',', $to) : '';
    }

    /**
     * @param mixed $to
     *
     * @return array
     */
    public function reverseTransform($to): array
    {
        return $to ? explode(',', str_replace(' ', '', trim($to))) : [];
    }
}
