<?php
namespace Vendor\Employee\Controller\Adminhtml\Staticpage;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('About This Module'));
        return $resultPage;
    }
}
