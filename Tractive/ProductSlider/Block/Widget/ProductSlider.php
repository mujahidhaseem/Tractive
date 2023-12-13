<?php
declare(strict_types=1);

namespace Tractive\ProductSlider\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class ProductSlider extends \Tractive\ProductSlider\Block\ProductSlider implements BlockInterface
{
    protected $_template = "widget/productslider.phtml";
}
