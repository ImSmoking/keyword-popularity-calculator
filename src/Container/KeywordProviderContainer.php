<?php

namespace App\Container;

use App\Service\GithubKeywordProvider;
use App\Service\KeywordProviderInterface;
use App\Service\TwitterKeywordProvider;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class KeywordProviderContainer implements ServiceSubscriberInterface
{

    private ContainerInterface $locator;

    public function __construct(
        ContainerInterface $locator
    )
    {
        $this->locator = $locator;
    }

    public static function getSubscribedServices(): array
    {
        return [
            'github' => GithubKeywordProvider::class,
            'twitter' => TwitterKeywordProvider::class
        ];
    }

    public static function getAvailableKeywordProviders(bool $asString = false): array|string
    {
        $availableKeywordProviders = array_keys(self::getSubscribedServices());
        if ($asString) {
            $availableKeywordProviders = "'" . implode("','", $availableKeywordProviders);
        }

        return $availableKeywordProviders;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $providerType): KeywordProviderInterface
    {
        return $this->locator->get($providerType);
    }
}