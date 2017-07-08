<?php declare(strict_types=1);

namespace Presenter;

use Model\WordAmount;

class OrderedPresenter
{
    /** @var WordAmount[] */
    private $orderedWords;

    public function __construct(array $words)
    {
        usort($words, function (WordAmount $a, WordAmount $b) {
            if ($a->amount() === $b->amount()) {
                return $a->word() <=> $b->word();
            } else {
                return $b->amount() <=> $a->amount();
            }
        });
        $this->orderedWords = $words;
    }

    public function __invoke(): string
    {
        $result = '';
        foreach ($this->orderedWords as $wordAmount) {
            $result .= sprintf('%s: %s', $wordAmount->word(), $wordAmount->amount()) . PHP_EOL;
        }
        return $result;
    }

    public function __toString(): string
    {
        return json_encode($this->orderedWords);
    }
}