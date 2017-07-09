<?php declare(strict_types=1);

namespace Tests\Presenter;

use PHPUnit\Framework\TestCase;
use Presenter\IndexPresenter;

class IndexPresenterTest extends TestCase
{
    public function testStress()
    {
        $wordLowerQty = 10000;
        $wordMediumQty = $wordLowerQty * 2;
        $wordHigherQty = $wordMediumQty * 3;

        $stringBuilder = new RepeatStringBuilder([
            'word_lower' => $wordLowerQty,
            'word_higher' => $wordHigherQty,
            'word_medium' => $wordMediumQty,
        ]);

        $temp = tmpfile();
        fwrite($temp, $stringBuilder());
        fseek($temp, 0);
        $this->assertEquals(
            "word_higher: $wordHigherQty\nword_medium: $wordMediumQty\nword_lower: $wordLowerQty\n",
            (new IndexPresenter($temp))()
        );
        fclose($temp);
    }
}