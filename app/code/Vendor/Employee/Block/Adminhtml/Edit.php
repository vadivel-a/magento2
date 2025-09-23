<?php
namespace Vendor\Employee\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Vendor\Employee\Model\EmployeeFactory;

class Edit extends Template
{
    protected $_template = 'Vendor_Employee::edit.phtml';
    protected $employeeFactory;

    public function __construct(Context $context, EmployeeFactory $employeeFactory, array $data = [])
    {
        parent::__construct($context, $data);
        $this->employeeFactory = $employeeFactory;
    }

    public function getEmployee()
    {
        $id = $this->getRequest()->getParam('employee_id');
        if ($id) {
            return $this->employeeFactory->create()->load($id);
        }
        return $this->employeeFactory->create();
    }

    public function getFormAction()
    {
        return $this->getUrl('employee/employee/save');
    }
}
