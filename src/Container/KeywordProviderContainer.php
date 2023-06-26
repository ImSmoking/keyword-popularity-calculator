<?php

namespace App\Container;

use App\Constant\KeywordConstant;
use App\Provider\AbstractKeywordProvider;
use App\Provider\GithubKeywordProvider;
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
            KeywordConstant::SOURCE_GITHUB => GithubKeywordProvider::class,
            // KeywordConstant::SOURCE_TWITTER => TwitterKeywordProvider::class
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