<?php

namespace Counter;

use Model\WordAmount;

class WordsCounterCalculation
{
    /** @var WordsStreamCounter[] */
    private $wordsCounterCollection;

    /**
     * @param WordsStreamCounter[] $collection
     */
    public function __construct(array $collection)
    {
        $this->wordsCounterCollection = $collection;
    }

    public function __invoke(): array
    {
        $final = [];
        /** @var WordsStreamCounter $streamCounter */
        foreach ($this->wordsCounterCollection as $streamCounter) {
            /** @var WordAmount $wordAmount */
            foreach ($streamCounter() as $wordAmount) {
                $final[$wordAmount->word()] = $wordAmount->amount()
                    + ($final[$wordAmount->word()] ?? 0);
            }
        }
        return $this->buildWordAmounts($final);
    }

    private function buildWordAmounts(array $countWords): array
    {
        return array_map(function ($word, $amount) {
            return new WordAmount((string)$word, $amount);
        }, array_keys($countWords), $countWords);
    }
}