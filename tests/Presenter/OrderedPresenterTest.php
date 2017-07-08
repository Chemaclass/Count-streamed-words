<?php declare(strict_types=1);

namespace Tests\Presenter;

use Model\WordAmount;
use PHPUnit\Framework\TestCase;
use Presenter\OrderedPresenter;

class OrderedPresenterTest extends TestCase
{
    public function testWordsStreamCounter()
    {
        $presenter = new OrderedPresenter([
            new WordAmount('one', 1),
            new WordAmount('two', 2),
        ]);
        $this->assertEquals('two: 2' . PHP_EOL . 'one: 1' . PHP_EOL, $presenter());
    }
}