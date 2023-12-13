<?php
declare(strict_types=1);

namespace Tractive\ProductSlider\Controller\Ajax;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Tractive\ProductSlider\Block\ProductSlider;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class Index implements HttpPostActionInterface
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * @var ProductSlider
     */
    protected $productSlider;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Main Construct
     *
     * @param JsonFactory $resultJsonFactory
     * @param JsonFactory $jsonFactory
     * @param LayoutInterface $layout
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ProductSlider $productSlider
     * @param array $data
     */
    public function __construct(
        JsonFactory $resultJsonFactory,
        JsonFactory $jsonFactory,
        LayoutInterface $layout,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductSlider $productSlider,
        array $data = []
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->jsonFactory = $jsonFactory;
        $this->layout = $layout;
        $this->productSlider = $productSlider;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Main Execute method
     *
     * @return ResponseInterface|Json|ResultInterface
     */
    public function execute()
    {
        
        $newProducts = $this->productSlider->getProducts();

        $resultJson = $this->jsonFactory->create();

        $resultJson->setData([
            "status" => true,
            "result" => $this->layout->createBlock(ProductSlider::class)
                            ->setTemplate("Tractive_ProductSlider::list/list.phtml")
                            ->setData([
                                "products" => $newProducts
                            ])->toHtml()
        ]);
        return $resultJson;
    }
}
