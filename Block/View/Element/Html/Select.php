<?php
/**
 * @package   Snowdog\AlpacaGeneral
 * @copyright 2021 Snowdog. All rights reserved.
 * @see       https://snow.dog/
 */

declare(strict_types=1);

namespace Snowdog\AlpacaGeneral\Block\View\Element\Html;

use Magento\Framework\View\Element\Html\Select as SelectElement;

class Select extends SelectElement
{
    /**
     * @inheritDoc
     */
    protected function _toHtml()
    {
        if (!parent::_toHtml()) {
            return '';
        }

        $originalSelectStartTag = '<select name="' .
            $this->getName() .
            '" id="' .
            $this->getId() .
            '" class="' .
            $this->getClass() .
            '" title="' .
            $this->escapeHtml($this->getTitle()) .
            '" ' .
            $this->getExtraParams() .
            '>';

        $customSelectStartTag = '<select data-mage-init=\'{ "select": {}}\' name="' .
            $this->getName() .
            '" id="' .
            $this->getId() .
            '" class="select__field ' .
            $this->getClass() .
            '" title="' .
            $this->escapeHtml($this->getTitle()) .
            '" ' .
            $this->getExtraParams() .
            '>';

        return str_replace(
            $originalSelectStartTag,
            $customSelectStartTag,
            parent::_toHtml()
        );
    }
}
