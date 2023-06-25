<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class KeywordException extends BaseException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, array $data = [])
    {
        parent::__construct($message, $code, $previous, $data);
    }


    /**
     * @throws KeywordException
     */
    public static function invalidLength(): self
    {
        throw new self(
            'exception.keyword.term.invalid_length',
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @throws KeywordException
     */
    public static function multipleWords()
    {
        throw new self(
            'exception.keyword.term.multiple_word',
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @throws KeywordException
     */
    public static function invalidSource(string $invalidSource, array $validSources): self
    {
        throw new self(
            'exception.keyword.source.invalid',
            Response::HTTP_BAD_REQUEST,
            null,
            [
                '%source%' => $invalidSource,
                '%valid_sources%' => "'" . implode("', '", $validSources) . "'"
            ]
        );
    }
}