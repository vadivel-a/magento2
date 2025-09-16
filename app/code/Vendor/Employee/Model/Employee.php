<?php
namespace Vendor\Employee\Model;

use Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Vendor\Employee\Model\ResourceModel\Employee');
    }
}
