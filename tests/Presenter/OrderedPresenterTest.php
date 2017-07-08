<?php declare(strict_types=1);

namespace Tests\Presenter;

use Model\WordAmount;
use PHPUnit\Framework\TestCase;
use Presenter\OrderedPresenter;

class OrderedPresenterTest extends TestCase
{
    public function testByAmount()
    {
        $presenter = new OrderedPresenter([
            new WordAmount('one', 1),
            new WordAmount('three', 3),
            new WordAmount('two', 2),
        ]);
        $this->assertEquals(
            'three: 3' . PHP_EOL . 'two: 2' . PHP_EOL . 'one: 1' . PHP_EOL,
            $presenter()
        );
    }

    public function testSameAmountByAlpha()
    {
        $presenter = new OrderedPresenter([
            new WordAmount('zero', 1),
            new WordAmount('one', 1),
            new WordAmount('two', 1),
        ]);
        $this->assertEquals(
            'one: 1' . PHP_EOL . 'two: 1' . PHP_EOL . 'zero: 1' . PHP_EOL,
            $presenter()
        );
    }

    public function testMixAmountAndAlpha()
    {
        $presenter = new OrderedPresenter([
            new WordAmount('twoZ', 2),
            new WordAmount('zero', 1),
            new WordAmount('twoA', 2),
            new WordAmount('four', 4),
        ]);
        $this->assertEquals(
            'four: 4' . PHP_EOL
            . 'twoA: 2' . PHP_EOL
            . 'twoZ: 2' . PHP_EOL
            . 'zero: 1' . PHP_EOL,
            $presenter()
        );
    }
}