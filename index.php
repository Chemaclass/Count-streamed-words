<?php
require __DIR__ . '/vendor/autoload.php';

use Presenter\IndexPresenter;

echo (new IndexPresenter)($argv[1]??'');
