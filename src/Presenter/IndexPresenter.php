<?php declare(strict_types=1);

namespace Presenter;

use Counter\WordsStreamCounter;

final class IndexPresenter
{
    const PRESENTER_TYPE_JSON = 'json';

    public function __invoke(string $type = '')
    {
        $stream = stream_get_contents(fopen("php://stdin", "r"));
        $wordsCounter = new WordsStreamCounter($stream);
        return $this->presenterFactory($type, $wordsCounter());
    }

    private function presenterFactory(string $type, array $wordAmounts)
    {
        $presenter = new OrderedPresenter($wordAmounts);
        if (self::PRESENTER_TYPE_JSON === $type) {
            return (string)($presenter);
        }
        return $presenter();
    }
}
