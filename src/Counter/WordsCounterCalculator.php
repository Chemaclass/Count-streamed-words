<?php declare(strict_types=1);

namespace Counter;

use Model\WordAmount;

class WordsCounterCalculator
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
        $finalAmounts = [];
        /** @var WordsStreamCounter $streamCounter */
        foreach ($this->wordsCounterCollection as $streamCounter) {
            /** @var WordAmount $wordAmount */
            foreach ($streamCounter() as $wordAmount) {
                $word = $wordAmount->word();
                if (!isset($finalAmounts[$word])) {
                    $finalAmounts[$word] = 0;
                }
                $finalAmounts[$word] += $wordAmount->amount();
            }
        }
        return WordAmount::buildCollectionFromArray($finalAmounts);
    }
}