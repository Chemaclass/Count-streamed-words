<?php declare(strict_types=1);

namespace Presenter;

use Counter\WordsCounterCalculation;
use Counter\WordsStreamCounter;

final class IndexPresenter
{
    const PRESENTER_TYPE_JSON = 'json';

    const SPECIAL_CHARS_PATTERN = '/[\'^£$%&*()}{@#~?><>,|=+¬-]/';

    public function __invoke(string $type = '')
    {
        $wordsResource = fopen("php://stdin", "r");
        $wordsCounterCollection = [];
        $rawString = '';
        while (false !== ($char = fgetc($wordsResource))) {
            if (preg_match(self::SPECIAL_CHARS_PATTERN, $char)) {
                $wordsCounterCollection[] = new WordsStreamCounter($rawString);
                $rawString = '';
            } else {
                $rawString .= $char;
            }
        }
        fclose($wordsResource);

        if (!empty($rawString)) {
            $wordsCounterCollection[] = new WordsStreamCounter($rawString);
        }

        $counterCalculator = new WordsCounterCalculation($wordsCounterCollection);

        return $this->presenterFactory($type, $counterCalculator());
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
