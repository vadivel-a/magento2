<?php
namespace Vendor\Employee\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Vendor\Employee\Model\EmployeeFactory;
use Vendor\Employee\Model\Config\Source\DepartmentOptions;

class Edit extends Template
{
    protected $_template = 'Vendor_Employee::edit.phtml';
    protected $employeeFactory;
    protected $departmentOptions;

    public function __construct(Context $context, EmployeeFactory $employeeFactory, DepartmentOptions $departmentOptions, array $data = [])
    {
        parent::__construct($context, $data);
        $this->employeeFactory = $employeeFactory;
        $this->departmentOptions = $departmentOptions;
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

    public function getDepartmentOptions(): array
    {
        return $this->departmentOptions->toOptionArray();
    }

}
