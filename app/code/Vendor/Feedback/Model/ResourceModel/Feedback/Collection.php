<?php
namespace Vendor\Feedback\Model\ResourceModel\Feedback;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vendor\Feedback\Model\Feedback as FeedbackModel;
use Vendor\Feedback\Model\ResourceModel\Feedback as FeedbackResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(FeedbackModel::class, FeedbackResource::class);
    }
}
