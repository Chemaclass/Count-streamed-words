<?php declare(strict_types=1);

namespace Tests\Counter;

use Counter\WordsStreamCounter;
use Model\WordAmount;
use PHPUnit\Framework\TestCase;

class WordsStreamCounterTest extends TestCase
{
    public function testWithMultiplePunctuationCharsAndSpace()
    {
        $wordsStreamCounter = new WordsStreamCounter('the one.two- ;the   three');

        $this->assertEquals([
            new WordAmount('the', 2),
            new WordAmount('one', 1),
            new WordAmount('two', 1),
            new WordAmount('three', 1),
        ], $wordsStreamCounter());
    }

}