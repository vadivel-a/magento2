<?php
namespace Vendor\Employee\Block;

use Magento\Framework\View\Element\Template;
use Vendor\Employee\Model\Config\Source\DepartmentOptions;

class EmployeeForm extends Template
{

    protected $employee;
    protected $departmentOptions;

    public function __construct(
        Template\Context $context,
        DepartmentOptions $departmentOptions, // inject the options source
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->departmentOptions = $departmentOptions;
    }

    /**
     * Set employee data (for edit form)
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
        return $this;
    }

    /**
     * Get employee data
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    public function getFormAction()
    {
        return $this->getUrl('employee/save');
    }

    public function getDepartmentOptions(): array
    {
        return $this->departmentOptions->toOptionArray();
    }
}
