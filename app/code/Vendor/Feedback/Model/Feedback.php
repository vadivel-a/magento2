<?php
namespace Vendor\Feedback\Model;

use Magento\Framework\Model\AbstractModel;
use Vendor\Feedback\Model\ResourceModel\Feedback as FeedbackResource;

class Feedback extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(FeedbackResource::class);
    }
}
