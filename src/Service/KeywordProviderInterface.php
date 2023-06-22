<?php

namespace App\Service;

interface KeywordProviderInterface
{

    public function getSource(): string;
    public function getHitsPositive(string $term): int;
    public function getHitsNegative(string $term): int;
}