<?php declare(strict_types=1);

namespace Tests\Presenter;

use PHPUnit\Framework\TestCase;

class IndexPresenterTest extends TestCase
{
    public function testStress()
    {
        $wordLowerQty = 1000;
        $wordMediumQty = $wordLowerQty * 2;
        $wordHigherQty = $wordMediumQty * 3;

        $stringBuilder = new RepeatStringBuilder([
            'word_lower' => $wordLowerQty,
            'word_higher' => $wordHigherQty,
            'word_medium' => $wordMediumQty,
        ]);

        $cmd = sprintf('echo "%s" | php index.php',$stringBuilder());
        $this->assertEquals(
            "word_higher: $wordHigherQty\nword_medium: $wordMediumQty\nword_lower: $wordLowerQty\n",
            shell_exec($cmd)
        );
    }
}