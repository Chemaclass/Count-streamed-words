<?php declare(strict_types=1);

namespace Tests\Counter;

use Counter\WordsCounterCalculator;
use Counter\WordsStreamCounter;
use Model\WordAmount;
use PHPUnit\Framework\TestCase;

class WordsCounterCalculatorTest extends TestCase
{
    public function testCalculation()
    {
        $collection = [];
        $collection[] = new WordsStreamCounter('uno dos dos');
        $collection[] = new WordsStreamCounter('tres tres tres');
        $collection[] = new WordsStreamCounter('cuatro cuatro cuatro');
        $collection[] = new WordsStreamCounter('cuatro cero');

        $this->assertEquals([
            new WordAmount('uno', 1),
            new WordAmount('dos', 2),
            new WordAmount('tres', 3),
            new WordAmount('cuatro', 4),
            new WordAmount('cero', 1),
        ], (new WordsCounterCalculator)->byStreams($collection));
    }

    public function testCalculationByWordAmounts()
    {
        $this->assertEquals([
            new WordAmount('uno', 1),
            new WordAmount('dos', 2),
            new WordAmount('tres', 3),
        ], (new WordsCounterCalculator)->byWords($this->generateWords()));
    }

    private function generateWords(){
        foreach(['uno','dos','tres','dos','tres','tres'] as $word){
            yield $word;
        }
    }

}