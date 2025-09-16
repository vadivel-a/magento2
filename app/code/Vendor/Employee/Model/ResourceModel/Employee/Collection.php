<?php
namespace Vendor\Employee\Model\ResourceModel\Employee;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Vendor\Employee\Model\Employee', 'Vendor\Employee\Model\ResourceModel\Employee');
    }
}
