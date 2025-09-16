<?php
namespace Vendor\Employee\Block;

use Magento\Framework\View\Element\Template;

class EmployeeForm extends Template
{

    protected $employee;

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
}
