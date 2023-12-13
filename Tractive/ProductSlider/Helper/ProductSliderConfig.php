<?php
declare(strict_types=1);

namespace Tractive\ProductSlider\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ProductSliderConfig
{
    public const MODULE_ENABLED = 'productslider/general/enable_module';
    public const BLOCK_TITLE = 'productslider/general/title';

    /**
     * @var ScopeConfigInterface $scopeConfig
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * Main Construct
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get Config Method
     *
     * @param string $conigPath
     * @return mixed
     */
    public function getConfig($conigPath)
    {
        return $this->scopeConfig->getValue($conigPath, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Is Module Enable
     *
     * @return mixed
     */
    public function isModuleEnable()
    {
        return $this->getConfig(self::MODULE_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Block Title
     *
     * @return mixed
     */
    public function getBlockTitle()
    {
        return $this->getConfig(self::BLOCK_TITLE, ScopeInterface::SCOPE_STORE);
    }
}
