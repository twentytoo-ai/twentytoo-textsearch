<?php
namespace TwentyToo\TextSearch\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Psr\Log\LoggerInterface;

class CustomProductDisplay
{
    protected $productRepository;
    protected $logger;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        LoggerInterface $logger
    ) {
        $this->productRepository = $productRepository;
        $this->logger = $logger;
    }

    public function afterGetItems(\Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $subject, $result)
    {
        $this->logger->info('Custom products display plugin triggered');

        // Static product IDs for testing purposes
        $productIds = [1, 2];
        $this->logger->info('Static product IDs ----> ' . json_encode($productIds));

        $customProducts = [];
        foreach ($productIds as $productId) {
            try {
                // Fetch the product object by its ID
                $product = $this->productRepository->getById((int)$productId); // Ensure ID is an integer
                if ($product) {
                    // Add the product object to the customProducts array
                    $customProducts[] = $product;
                    // Log details for debugging
                    $this->logger->info('Loaded product ID: ' . $product->getId());
                    $this->logger->info('Product Name: ' . $product->getName());
                    $this->logger->info('Product Visibility: ' . $product->getVisibility());
                    $this->logger->info('Product Status: ' . $product->getStatus());
                    $this->logger->info('Product Image: ' . $product->getImage());
                } else {
                    $this->logger->error('Product ID ' . $productId . ' not found.');
                }
            } catch (\Exception $e) {
                $this->logger->error('Error loading product ID ' . $productId . ': ' . $e->getMessage());
            }
        }

        // Return the custom product objects, which are instances of \Magento\Catalog\Model\Product
        $this->logger->info('Product data: ' . print_r($product->debug(), true));
        return $customProducts;
    }
}
