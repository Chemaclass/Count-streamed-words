<?php

namespace Tests\AcceptanceCriteria;

final class RepeatStringBuilder
{
    /** @var string */
    private $result = '';

    public function __construct(array $criteria = [])
    {
        foreach ($criteria as $word => $qty) {
            $this->result .= ' ' . str_repeat($word . ' ', $qty);
        }
    }

    public function __invoke(): string
    {
        return $this->result;
    }
}