<?php
require __DIR__ . '/vendor/autoload.php';

use Presenter\IndexPresenter;

$wordsResource = fopen("php://stdin", "r");
echo (new IndexPresenter($wordsResource))($argv[1]??'');
fclose($wordsResource);
