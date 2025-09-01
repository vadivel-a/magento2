<?php
namespace Vendor\Feedback\Block;

use Magento\Framework\View\Element\Template;
use Vendor\Feedback\Model\ResourceModel\Feedback\CollectionFactory;

class FeedbackList extends Template
{
    protected $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getFeedbackCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->setOrder('created_at', 'DESC');
        return $collection;
    }
}
