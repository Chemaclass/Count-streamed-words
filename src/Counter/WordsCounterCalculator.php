<?php declare(strict_types=1);

namespace Counter;

use Model\WordAmount;

class WordsCounterCalculator
{
    /**
     * @param WordsStreamCounter[] $collection
     * @return WordAmount[]
     */
    public function byStreams(array $collection): array
    {
        $finalAmounts = [];
        /** @var WordsStreamCounter $streamCounter */
        foreach ($collection as $streamCounter) {
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

    /**
     * @param \Generator $collection
     * @return WordAmount[]
     */
    public function byWords(\Generator $collection): array
    {
        $finalAmounts = [];
        /** @var string $word */
        foreach ($collection as $word) {
            if (!isset($finalAmounts[$word])) {
                $finalAmounts[$word] = 0;
            }
            $finalAmounts[$word]++;
        }
        return WordAmount::buildCollectionFromArray($finalAmounts);
    }
}