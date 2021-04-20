<?php
/**
 * @package   Snowdog\AlpacaGeneral
 * @copyright 2021 Snowdog. All rights reserved.
 * @see       https://snow.dog/
 */

declare(strict_types=1);

namespace Snowdog\AlpacaGeneral\Preference\Magento\CatalogSearch\Block;

use Magento\CatalogSearch\Block\Result as CatalogSearchBlockResult;

class Result extends CatalogSearchBlockResult
{
    /**
     * Prepare layout
     *
     * @return CatalogSearchBlockResult
     */
    protected function _prepareLayout()
    {
        if (!$this->catalogLayer->getProductCollection()->getSize()) {
            $this->pageConfig->addBodyClass('search-no-result');
        }

        return parent::_prepareLayout();
    }
}
