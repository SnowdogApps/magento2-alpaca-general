<?php
/**
 * @package   Snowdog\AlpacaGeneral
 * @copyright 2021 Snowdog. All rights reserved.
 * @see       https://snow.dog/
 */

declare(strict_types=1);

namespace Snowdog\AlpacaGeneral\Plugin;

use Smile\ElasticsuiteCore\Index\IndexOperation;
use Psr\Log\LoggerInterface;
use Magento\Sales\Model\Service\OrderService;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\Exception\LocalizedException;

class CheckElasticSearchAvailabilityPlugin
{
    /**
     * @var IndexOperation
     */
    private $indexOperation;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        IndexOperation $indexOperation,
        LoggerInterface $logger
    ) {
        $this->indexOperation = $indexOperation;
        $this->logger = $logger;
    }

    /**
     * @throws LocalizedException
     */
    public function aroundPlace(
        OrderService $subject,
        callable $proceed,
        OrderInterface $order
    ): OrderInterface {
        if (!$this->indexOperation->isAvailable()) {
            $this->logger->critical(
                'Saving order ' . $order->getIncrementId() . ' failed. ES is not available.'
            );
            throw new LocalizedException(
                __('Saving order failed. ES is not available.')
            );
        }

        return $proceed($order);
    }
}
