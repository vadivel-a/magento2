<?php
namespace Vendor\Employee\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Employee extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('vendor_employee', 'employee_id');
    }
}
