<?php
namespace Vendor\Feedback\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Feedback extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('vendor_feedback', 'feedback_id');
    }
}
