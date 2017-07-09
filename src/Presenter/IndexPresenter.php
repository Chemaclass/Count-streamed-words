<?php declare(strict_types=1);

namespace Presenter;

use Counter\WordsCounterCalculator;
use Counter\WordsStreamCounter;

final class IndexPresenter
{
    const PRESENTER_TYPE_JSON = 'json';

    const SPECIAL_CHARS_PATTERN = '/[\'^£$%&*()}{@#~?><>,|=+¬-]/';

    /** @var WordsStreamCounter[] */
    private $wordStreamCollection;

    function __construct()
    {
        $wordsResource = fopen("php://stdin", "r");
        $this->wordStreamCollection = $this->buildCollection($wordsResource);
        fclose($wordsResource);
    }

    private function buildCollection($wordsResource): array
    {
        $counterCollection = [];
        $rawString = '';
        while (false !== ($char = fgetc($wordsResource))) {
            if (preg_match(self::SPECIAL_CHARS_PATTERN, $char)) {
                $counterCollection[] = new WordsStreamCounter($rawString);
                $rawString = '';
            } else {
                $rawString .= $char;
            }
        }
        if (!empty($rawString)) {
            $counterCollection[] = new WordsStreamCounter($rawString);
        }
        return $counterCollection;
    }

    public function __invoke(string $type = '')
    {
        $counterCalculator = new WordsCounterCalculator($this->wordStreamCollection);
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
