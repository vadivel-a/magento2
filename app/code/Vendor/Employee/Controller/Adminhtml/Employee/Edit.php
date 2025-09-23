<?php
namespace Vendor\Employee\Controller\Adminhtml\Employee;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Vendor\Employee\Model\EmployeeFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $employeeFactory;

public function __construct(Action\Context $context)
{
    parent::__construct($context);
    $this->resultPageFactory = \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Framework\View\Result\PageFactory::class);
    $this->employeeFactory = \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Vendor\Employee\Model\EmployeeFactory::class);
}


    public function execute()
    {
        $id = $this->getRequest()->getParam('employee_id');
        $employee = $this->employeeFactory->create();

        if ($id) {
            $employee->load($id);
            if (!$employee->getId()) {
                $this->messageManager->addErrorMessage(__('Employee not found.'));
                return $this->_redirect('employee/employee/index');
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Employee') : __('Add New Employee'));

        // Pass employee ID to block via layout (optional, block can also load from request)
        $resultPage->addHandle('employee_employee_edit');

        return $resultPage;
    }
}
