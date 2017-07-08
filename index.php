<?php
require __DIR__ . '/vendor/autoload.php';

use Counter\WordsStreamCounter;
use Presenter\OrderedPresenter;

final class Index
{
    const PRESENTER_TYPE_JSON = 'json';

    public function __invoke(string $type = '')
    {
        $stream = stream_get_contents(fopen("php://stdin", "r"));
        $wordsCounter = new WordsStreamCounter($stream);
        return $this->presenterFactory($type, $wordsCounter);
    }

    private function presenterFactory(string $type, WordsStreamCounter $wordsCounter)
    {
        $presenter = new OrderedPresenter($wordsCounter());
        if (self::PRESENTER_TYPE_JSON === $type) {
            return (string)($presenter);
        }
        return $presenter();
    }
}

echo (new Index)($argv[1]??'');
