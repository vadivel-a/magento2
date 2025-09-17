<?php
namespace Vendor\Employee\Controller\Adminhtml\Employee;

use Magento\Backend\App\Action;
use Vendor\Employee\Model\EmployeeFactory;

class Delete extends Action
{
    protected $employeeFactory;

    public function __construct(
        Action\Context $context,
        EmployeeFactory $employeeFactory
    ) {
        parent::__construct($context);
        $this->employeeFactory = $employeeFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $employee = $this->employeeFactory->create()->load($id);
                $employee->delete();
                $this->messageManager->addSuccessMessage(__('Employee deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error deleting employee: %1', $e->getMessage()));
            }
        }
        return $this->_redirect('employee/employee/index');
    }
}
