<?php declare(strict_types=1);

namespace Tests\Presenter;

use PHPUnit\Framework\TestCase;
use Presenter\IndexPresenter;

class IndexPresenterTest extends TestCase
{
    public function testStress()
    {
        $this->markTestSkipped('This test take a while to process this amount of data');
        $wordLowerQty = 10000;
        $wordMediumQty = 100000;
        $wordHigherQty = 1000000;

        $stringBuilder = new RepeatStringBuilder([
            'word_lower' => $wordLowerQty,
            'word_higher' => $wordHigherQty,
            'word_medium' => $wordMediumQty,
        ]);

        $tempResource = tmpfile();
        fwrite($tempResource, $stringBuilder());
        fseek($tempResource, 0);
        $this->assertEquals(
            "word_higher: $wordHigherQty\nword_medium: $wordMediumQty\nword_lower: $wordLowerQty\n",
            (new IndexPresenter($tempResource))()
        );
        fclose($tempResource);
    }
}