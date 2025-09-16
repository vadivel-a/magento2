<?php
namespace Vendor\Student\Controller\Edit;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ){
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        echo $id;
        if (!$id) {
            // Magento will show 404 if parameter is missing
            $this->_forward('noroute'); 
            return;
        }

        // Return a simple page for testing
        echo "Edit Student Page - ID: " . $id;
        exit;
    }
}
