<?php declare(strict_types=1);

namespace Counter;

use Model\WordAmount;

final class WordsStreamCounter
{
    /** @var WordAmount[] */
    private $wordAmounts;

    public function __construct(string $rawString)
    {
        $words = preg_split('/(\W+)/', $rawString);
        $countWords = array_count_values(
            array_map(
                'strtolower',
                array_filter($words, 'strlen')
            )
        );
        $this->wordAmounts = WordAmount::buildCollectionFromArray($countWords);
    }

    public function __invoke(): array
    {
        return $this->wordAmounts;
    }
}