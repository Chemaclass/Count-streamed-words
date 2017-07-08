<?php
require __DIR__ . '/vendor/autoload.php';

use Counter\WordsStreamCounter;
use Presenter\OrderedPresenter;

$stream = stream_get_contents(fopen("php://stdin", "r"));
$wordsCounter = new WordsStreamCounter($stream);

echo (new OrderedPresenter($wordsCounter()))();

echo PHP_EOL;

