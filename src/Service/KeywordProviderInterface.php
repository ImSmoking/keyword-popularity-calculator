<?php

namespace App\Service;

interface KeywordProviderInterface
{

    public function getSource(): string;
    public function getHitsRocks(string $term): int;
    public function getHitsSucks(string $term): int;
}