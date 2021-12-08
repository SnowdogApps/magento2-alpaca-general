<?php
/**
 * @package   Snowdog\AlpacaGeneral
 * @copyright 2021 Snowdog. All rights reserved.
 * @see       https://snow.dog/
 */

declare(strict_types=1);

namespace Snowdog\AlpacaGeneral\CustomerData;

use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Helper\Product\ConfigurationPool as ProductConfigurationPool;
use Magento\Catalog\Model\Product\Configuration\Item\ItemResolverInterface;
use Magento\Checkout\CustomerData\DefaultItem as ParentDefaultItem;
use Magento\Checkout\Helper\Data as CheckoutHelper;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Msrp\Helper\Data as MsrpHelper;
use Snowdog\AlpacaGeneral\Model\Config;

class DefaultItem extends ParentDefaultItem
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        ImageHelper $imageHelper,
        MsrpHelper $msrpHelper,
        UrlInterface $urlBuilder,
        ProductConfigurationPool $configurationPool,
        CheckoutHelper $checkoutHelper,
        Config $config,
        Escaper $escaper = null,
        ItemResolverInterface $itemResolver = null
    ) {
        $this->config = $config;
        
        parent::__construct(
            $imageHelper,
            $msrpHelper,
            $urlBuilder,
            $configurationPool,
            $checkoutHelper,
            $escaper,
            $itemResolver
        );
    }

    /**
     * @inheritdoc
     */
    protected function doGetItemData()
    {
        $data = parent::doGetItemData();
        $data['qty_update_disabled'] = $this->config->isQtyUpdateDisabled();

        return $data;
    }
}
