<?php
/**
 * @package   Snowdog\AlpacaGeneral
 * @copyright 2021 Snowdog. All rights reserved.
 * @see       https://snow.dog/
 */

declare(strict_types=1);

namespace Snowdog\AlpacaGeneral\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /**
     * System config XML paths.
     */
    private const XML_PATH_QTY_UPDATE_DISABLED = 'alpaca_general/minicart/qty_update_disabled';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var bool|null
     */
    private $isQtyUpdateDisabled = null;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function isQtyUpdateDisabled(): bool
    {
        if ($this->isQtyUpdateDisabled === null) {
            $this->isQtyUpdateDisabled = $this->scopeConfig->isSetFlag(
                self::XML_PATH_QTY_UPDATE_DISABLED,
                ScopeInterface::SCOPE_STORE
            );
        }

        return $this->isQtyUpdateDisabled;
    }
}
