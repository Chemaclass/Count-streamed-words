<?php declare(strict_types=1);

namespace Counter;

use Model\WordAmount;

final class WordsStreamCounter
{
    /** @var array */
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
        $this->wordAmounts = $this->buildWordAmounts($countWords);
    }

    private function buildWordAmounts(array $countWords): array
    {
        return array_map(function ($word, $amount) {
            return new WordAmount((string)$word, $amount);
        }, array_keys($countWords), $countWords);
    }

    public function __invoke(): array
    {
        return $this->wordAmounts;
    }
}