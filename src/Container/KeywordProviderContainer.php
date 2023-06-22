<?php

namespace App\Container;

use App\Provider\AbstractKeywordProvider;
use App\Provider\GithubKeywordProvider;
use App\Provider\KeywordProviderInterface;
use App\Provider\TwitterKeywordProvider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

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
    public function get(string $providerType): AbstractKeywordProvider
    {
        return $this->locator->get($providerType);
    }
}