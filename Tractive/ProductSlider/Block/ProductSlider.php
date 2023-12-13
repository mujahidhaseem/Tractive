<?php
declare(strict_types=1);

namespace Tractive\ProductSlider\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http;
use Magento\Store\Model\ScopeInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Helper\Output;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Tractive\ProductSlider\Helper\ProductSliderConfig;
use Magento\Framework\Locale\CurrencyInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class ProductSlider extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CurrencyInterface
     */
    protected $currencyInterface;

    /**
     * @var Context
     */
    public Context $context;

    /**
     * @var ListProduct
     */
    protected $listProduct;

    /**
     * @var BackendHelper
     */
    protected $backendHelper;

    /**
     * @var Output
     */
    protected Output $helperCatalog;

    /**
     * @var ScopeConfigInterface
     */
    public ScopeConfigInterface $scopeConfig;

    /**
     * @var Http
     */
    protected Http $request;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $productsFactory;

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productFactory;

    /**
     * @var ProductSliderConfig
     */
    protected $helperConfig;
    
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    
    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * ProductSlider constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ProductRepositoryInterface $productFactory
     * @param Http $request
     * @param Context $context
     * @param Data $backendHelper
     * @param ListProduct $listProduct
     * @param Output $helperCatalog
     * @param CollectionFactory $productsFactory
     * @param ProductSliderConfig $helperConfig
     * @param StoreManagerInterface $storeManager
     * @param CurrencyInterface $currencyInterface
     * @param FormKey $formKey
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ProductRepositoryInterface $productFactory,
        Http $request,
        Context $context,
        Data $backendHelper,
        ListProduct $listProduct,
        Output $helperCatalog,
        CollectionFactory $productsFactory,
        ProductSliderConfig $helperConfig,
        StoreManagerInterface $storeManager,
        FormKey $formKey,
        CurrencyInterface $currencyInterface,
        array $data = []
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->listProduct = $listProduct;
        $this->helperCatalog = $helperCatalog;
        $this->productsFactory = $productsFactory;
        $this->helperConfig = $helperConfig;
        $this->storeManager = $storeManager;
        $this->formKey = $formKey;
        $this->currencyInterface = $currencyInterface;
    }

    /**
     * Get Ajax Url
     *
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl("productslider/ajax/index");
    }

    /**
     * Method Get Load Product
     *
     * @param object $id
     * @return object
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLoadProduct($id):object
    {
        return $this->productFactory->getById($id);
    }

    /**
     * Method Get List Product
     *
     * @return ListProduct
     */
    public function getListProduct(): ListProduct
    {
        return $this->listProduct;
    }

    /**
     * Get Catalog Helper
     *
     * @return Output
     */
    public function getCatalogHelper(): Output
    {
        return $this->helperCatalog;
    }

    /**
     * Method Get Lazy Loaded Image
     *
     * @param string $productImage
     * @return string
     */
    public function getLazyLoadedImage($productImage): string
    {
        return $imageElement = $productImage->toHtml();
        //return str_replace('src', 'data-lazy', $imageElement);
    }

    /**
     * Product Counts
     *
     * @return mixed
     */
    public function getProductCount()
    {
        return $this->helperConfig->getProductCount();
    }

    /**
     * Get Block Title
     *
     * @return mixed
     */
    public function getBlockTitle()
    {
        return $this->helperConfig->getBlockTitle();
    }

    /**
     * Is Module Enable
     *
     * @return mixed
     */
    public function isModuleEnable()
    {
        return $this->helperConfig->isModuleEnable();
    }

    /**
     * Get Products
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProducts()
    {
        $collection = $this->productsFactory->create()
            ->addAttributeToSelect('*')
            ->setPageSize(10)
            ->addAttributeToSort('entity_id', 'desc')
            ->load();

        return $collection;
    }

    /**
     * Get Currency
     *
     * @return mixed
     */
    public function getCurrency()
    {
        $storeId = $this->storeManager->getStore()->getId();
        $currencyCode = $this->storeManager->getStore($storeId)->getCurrentCurrencyCode();
        return $this->currencyInterface->getCurrency($currencyCode)->getSymbol();
    }

    /**
     * Get Form Key
     *
     * @return mixed
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}
