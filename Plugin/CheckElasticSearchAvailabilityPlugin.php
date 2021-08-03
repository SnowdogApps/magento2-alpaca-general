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
    private IndexOperation $indexOperation;

    private LoggerInterface $logger;

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
    public function beforePlace(
        OrderService $subject,
        OrderInterface $order
    ): void {
        if (!$this->indexOperation->isAvailable()) {
            $this->logger->critical(
                'Saving order ' . $order->getIncrementId() . ' failed. ES is not available.'
            );
            throw new LocalizedException(
                __('Saving order failed. ES is not available.')
            );
        }
    }
}
