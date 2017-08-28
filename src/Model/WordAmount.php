<?php declare(strict_types=1);

namespace Model;

class WordAmount implements \JsonSerializable
{
    /** @var string */
    private $word;

    /** @var int */
    private $amount;

    public function __construct(string $word, int $amount = 1)
    {
        $this->word = $word;
        $this->amount = $amount;
    }

    public static function buildCollectionFromArray(array $countWords): array
    {
        return array_map(function ($word, $amount) {
            return new WordAmount((string)$word, $amount);
        }, array_keys($countWords), $countWords);
    }

    public function word(): string
    {
        return $this->word;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}