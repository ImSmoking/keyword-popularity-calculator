<?php

namespace App\Service;

use App\Entity\Keyword;
use App\Handler\KeywordScoreHandler;
use App\Repository\KeywordRepository;

abstract class AbstractKeywordProvider implements KeywordProvider
{
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

    public function getKeyword(string $term): Keyword
    {
        if (!is_null($keyword = $this->keywordRepository->findOneByTermAndSource($term, $this->getSource()))) {
            $keyword->increaseSearch();
            $this->keywordRepository->save($keyword, true);
            return $keyword;
        }

        $keyword = (new Keyword())
            ->setTerm($term)
            ->setSource($this->getSource())
            ->setHitsRocks($this->getHitsRocks($term))
            ->setHitsSucks($this->getHitsSucks($term))
            ->setCreatedAt(new \DateTimeImmutable())
            ->increaseSearch();

        $keyword = $this->keywordScoreHandler->calculateScore($keyword);

        $this->keywordRepository->save($keyword, true);

        return $keyword;
    }
}