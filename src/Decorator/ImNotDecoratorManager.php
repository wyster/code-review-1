<?php

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use src\Decorator\ResponseInterface;
use Psr\Log\LoggerInterface;
use src\Integration\DataProvider;
use src\Integration\RequestParamsInterface;

class ImNotDecoratorManager
{
    private $cache;
    private $logger;
    private $dataProvider;

    public function __construct(CacheItemPoolInterface $cache, LoggerInterface $logger, DataProvider $dataProvider)
    {
        $this->cache = $cache;
        $this->logger = $logger;
        $this->dataProvider = $dataProvider;
    }

    public function getResponse(RequestParamsInterface $params): ResponseInterface
    {
        try {
            $cacheKey = $this->getCacheKey($params);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $response = $this->dataProvider->get($params);

            $result = $this->prepareResponse($response);

            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify('+1 day')
                );
        } catch (Exception $e) {
            $this->logger->critical(sprintf('Error: %s', $e->getMessage()));
            throw new $e;
        }

        return $result;
    }

    private function getCacheKey(RequestParamsInterface $params): string
    {
        return json_encode($params->getData(), JSON_THROW_ON_ERROR);
    }

    private function prepareResponse(PsrResponseInterface $response): ResponseInterface
    {

    }
}