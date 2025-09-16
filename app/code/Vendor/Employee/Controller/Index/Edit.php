<?php
namespace Vendor\Employee\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Vendor\Employee\Model\EmployeeFactory;

class Edit extends Action
{
    protected $employeeFactory;

    public function __construct(Context $context, EmployeeFactory $employeeFactory)
    {
        $this->employeeFactory = $employeeFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $employee = $this->employeeFactory->create()->load($id);

        if (!$employee->getId()) {
            $this->messageManager->addErrorMessage(__('Employee not found'));
            return $this->_redirect('*/*/');
        }

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->set(__('Edit Employee'));
        $resultPage->getLayout()->getBlock('employee_edit')->setEmployee($employee);

        return $resultPage;
    }
}
