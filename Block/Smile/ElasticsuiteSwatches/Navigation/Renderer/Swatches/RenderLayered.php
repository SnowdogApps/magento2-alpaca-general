<?php
/**
 * @package   Snowdog\AlpacaGeneral
 * @copyright 2021 Snowdog. All rights reserved.
 * @see       https://snow.dog/
 */

declare(strict_types=1);

namespace Snowdog\AlpacaGeneral\Block\Smile\ElasticsuiteSwatches\Navigation\Renderer\Swatches;

use Magento\Eav\Model\Entity\Attribute;
use RuntimeException;
use Smile\ElasticsuiteCore\Search\Request\BucketInterface;
use Smile\ElasticsuiteSwatches\Block\Navigation\Renderer\Swatches\RenderLayered as ParentBlock;

class RenderLayered extends ParentBlock
{
    /**
     * @inheritDoc
     */
    public function getSwatchData(): array
    {
        // Fallback to core if sorting is set to manual.
        if ($this->eavAttribute->getFacetSortOrder() === BucketInterface::SORT_ORDER_MANUAL) {
            return parent::getSwatchData();
        }

        if (false === $this->eavAttribute instanceof Attribute) {
            throw new RuntimeException('Magento_Swatches: RenderLayered: Attribute has not been set.');
        }

        $attributeOptions = [];
        // Collect parameter labels in the expected order.
        $attributeOptionsSort = [];
        // Build an array whose keys are the attribute option label and not option id as in the native method.
        $sortingArr = [];
        foreach ($this->filter->getItems() as $item) {
            $sortingArr[] = $item['label'];
        }

        foreach ($this->eavAttribute->getOptions() as $option) {
            if ($currentOption = $this->getFilterOption($this->filter->getItems(), $option)) {
                /*
                 * Built the array with the attribute options in the expected orders with the attribute option id
                 * as keys, because it's a requirement for the getSwatchesByOptionsId helper method.
                 */
                $attributeOptions[$option->getLabel()] = array_merge($currentOption, ['id' => $option->getValue()]);
            } elseif ($this->isShowEmptyResults()) {
                $attributeOptions[$option->getLabel()] = array_merge($this->getUnusedOption($option), ['id' => $option->getValue()]);
            }
        }

        foreach (array_merge(array_flip($sortingArr), $attributeOptions) as $item) {
            if (is_array($item) && array_key_exists('id', $item)) {
                $attributeOptionsSort[$item['id']] = $item;
            }
        }

        $attributeOptionIds = array_keys($attributeOptionsSort);
        $swatches = $this->swatchHelper->getSwatchesByOptionsId($attributeOptionIds);

        $data = [
            'attribute_id' => $this->eavAttribute->getId(),
            'attribute_code' => $this->eavAttribute->getAttributeCode(),
            'attribute_label' => $this->eavAttribute->getStoreLabel(),
            'options' => $attributeOptionsSort,
            'swatches' => $swatches,
        ];

        return $data;
    }
}
