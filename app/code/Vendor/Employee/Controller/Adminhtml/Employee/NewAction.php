<?php
namespace Vendor\Employee\Controller\Adminhtml\Employee;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Action
{
    protected $resultPageFactory;

    public function __construct(Action\Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Add New Employee'));
        return $resultPage;
    }
}
