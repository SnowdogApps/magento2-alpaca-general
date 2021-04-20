<?php
/**
 * @package   Snowdog\AlpacaGeneral
 * @copyright 2021 Snowdog. All rights reserved.
 * @see       https://snow.dog/
 */

declare(strict_types=1);

namespace Snowdog\AlpacaGeneral\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\LayoutInterface;
use Snowdog\AlpacaGeneral\Block\View\Element\Html\Select;

class SelectElement implements ArgumentInterface
{
    /**
     * @var LayoutInterface
     */
    private $layout;

    public function __construct(LayoutInterface $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param mixed $value
     */
    public function getSelectHtml(
        string $name,
        string $id,
        string $class = '',
        array $options = [],
        $value = null
    ): string {
        $select = $this->layout->createBlock(
            Select::class
        )->setName(
            $name
        )->setId(
            $id
        )->setClass(
            $class
        )->setValue(
            $value
        )->setOptions(
            $options
        );

        return $select->getHtml();
    }
}
