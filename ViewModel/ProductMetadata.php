<?php

declare(strict_types=1);

namespace Snowdog\AlpacaGeneral\ViewModel;

use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductMetadata implements ArgumentInterface
{
    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    public function __construct(ProductMetadataInterface $productMetadata)
    {
        $this->productMetadata = $productMetadata;
    }

    public function getEdition() : string
    {
        return $this->productMetadata->getEdition();
    }

    public function isB2B(): bool
    {
        return $this->getEdition() == 'B2B';
    }
}
