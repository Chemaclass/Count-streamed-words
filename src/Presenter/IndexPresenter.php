<?php declare(strict_types=1);

namespace Presenter;

use Counter\WordsCounterCalculator;
use Counter\WordsStreamCounter;

final class IndexPresenter
{
    const PRESENTER_TYPE_JSON = 'json';

    const SPECIAL_CHARS_PATTERN = '/[\'^£$%&*()}{@#~?><>,|=+¬-][^\s]/';

    /** @var resource */
    private $wordsResource;

    /**
     * @param resource $wordsResource
     */
    public function __construct($wordsResource)
    {
        $this->wordsResource = $wordsResource;
    }

    public function __invoke(string $type = '')
    {
        $wordsAmount = (new WordsCounterCalculator)
            ->byWords($this->buildWords($this->wordsResource));
        $presenter = new OrderedPresenter($wordsAmount);
        if (self::PRESENTER_TYPE_JSON === $type) {
            return (string)($presenter);
        }
        return $presenter();
    }

    private function buildWords($wordsResource): \Generator
    {
        $rawString = '';
        while (false !== ($char = fgetc($wordsResource))) {
            if (preg_match(WordsStreamCounter::ONLY_WORDS_PATTERN, $char)) {
                $rawString .= $char;
            } elseif(!empty($rawString)){
                yield $rawString;
                $rawString = '';
            }
        }
        if (!empty($rawString)) {
            yield $rawString;
        }
    }

}
