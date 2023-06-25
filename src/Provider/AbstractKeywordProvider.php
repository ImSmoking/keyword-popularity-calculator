<?php

namespace App\Provider;

use App\Entity\Keyword;
use App\Exception\KeywordException;
use App\Handler\KeywordScoreHandler;
use App\Repository\KeywordRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractKeywordProvider implements KeywordProviderInterface
{
    const POSITIVE_CONTEXT = 'rocks';
    const NEGATIVE_CONTEXT = 'sucks';
    private KeywordRepository $keywordRepository;
    private KeywordScoreHandler $keywordScoreHandler;

    public function __construct(
        KeywordRepository   $keywordRepository,
        KeywordScoreHandler $keywordScoreHandler
    )
    {
        $this->keywordRepository = $keywordRepository;
        $this->keywordScoreHandler = $keywordScoreHandler;
    }

    /**
     * @throws KeywordException
     */
    public function getKeyword(string $term): Keyword
    {
        if (!$this->isTermLengthValid($term)) {
            KeywordException::invalidLength();
        }
        if (!$this->isTermSingleWord($term)) {
            KeywordException::multipleWords();
        }

        if (!is_null($keyword = $this->keywordRepository->findOneByTermAndSource($term, $this->getSource()))) {
            $keyword->increaseSearch();
            $this->keywordRepository->save($keyword, true);
            return $keyword;
        }

        $keyword = $this->prepareKeyword($term);
        $keyword = $this->keywordScoreHandler->calculateScore($keyword);

        $this->keywordRepository->save($keyword, true);

        return $keyword;
    }

    private function prepareKeyword(string $term): Keyword
    {
        return (new Keyword())
            ->setTerm($term)
            ->setSource($this->getSource())
            ->setHitsPositive($this->getHitsPositive($term))
            ->setHitsNegative($this->getHitsNegative($term))
            ->setCreatedAt()
            ->increaseSearch();
    }

    private function isTermLengthValid(string $term): bool
    {
        if (strlen($term) < 2 || strlen($term) > 255) {
            return false;
        }

        return true;
    }

    private function isTermSingleWord(string $term): bool
    {
        if (str_contains($term, ' ')) {
            return false;
        }

        return true;
    }
}