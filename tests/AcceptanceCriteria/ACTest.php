<?php declare(strict_types=1);

namespace Tests\AcceptanceCriteria;

use PHPUnit\Framework\TestCase;

class ACTest extends TestCase
{
    public function testValuesPipedDirectlyIntoTheProcess()
    {
        $cmd = 'cat tests/AcceptanceCriteria/InputExample.txt | php index.php';
        $this->assertEquals(
            "the: 2\nbrown: 1\ndog: 1\nfox: 1\njumps: 1\nlazy: 1\nover: 1\nquick: 1\n",
            shell_exec($cmd)
        );
    }

    public function testValuesGeneratedByUsingASecureRandomSource()
    {
        // This test make no sense because the result came from a random generated string.
        $this->markTestSkipped('Not necessary');
    }

    public function testValuesLoadedViaHTTPUsingWikipediaRawTextAPI()
    {
        $url = 'https://en.wikipedia.org/wiki/Main_Page?action=raw';
        $cmd = "wget -q -O- $url | php index.php | head -n 3";

        // This test make no sense because the result will depend on the
        // external resource. Which it could change its content, for sure.
//        $this->assertEquals( "style: 52\ncolor: 36\n0: 32\n", shell_exec($cmd));
        // That's the reason why I just do this "dummy" test. Just as example.
        $this->assertTrue(strlen(shell_exec($cmd)) > 0);
    }

    public function testStress()
    {
        $wordLowerQty = 1000;
        $wordMediumQty = $wordLowerQty * 2;
        $wordHigherQty = $wordMediumQty * 2;

        $stringBuilder = new RepeatStringBuilder([
            'word_lower' => $wordLowerQty,
            'word_higher' => $wordHigherQty,
            'word_medium' => $wordMediumQty,
        ]);
        $cmd = sprintf('echo "%s" | php index.php', $stringBuilder());

        $this->assertEquals(
            "word_higher: $wordHigherQty\nword_medium: $wordMediumQty\nword_lower: $wordLowerQty\n",
            shell_exec($cmd)
        );
    }
}