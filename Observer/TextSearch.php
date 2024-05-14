<?php
namespace TwentyToo\TextSearch\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class TextSearch implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Request\Http $request
     */
    public function __construct(
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->request = $request;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        // Check if the request is for a search
        $controller = $observer->getControllerAction();
        if ($controller->getRequest()->getFullActionName() == 'catalogsearch_result_index') {
            // Get search query
            $query = $controller->getRequest()->getParam('q');

            // You can now make your API call using $query
            // Example:
            // $this->callApi($query);
            // For demonstration purpose, let's just log the search query
            $this->logSearchQuery($query);
        }
    }

    /**
     * Log the search query
     *
     * @param string $query
     * @return void
     */
    protected function logSearchQuery($query)
    {
        // Log the search query
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->info('Search Query: ' . $query);
    }
}
