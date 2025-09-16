<?php
namespace Vendor\Employee\Block;

use Magento\Framework\View\Element\Template;
use Vendor\Employee\Model\ResourceModel\Employee\CollectionFactory;

class EmployeeList extends Template
{
    protected $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    public function getCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->setOrder('created_at', 'DESC');
        return $collection;
    }

    public function getAddUrl()
    {
        return $this->getUrl('employee/index/add');
    }

    public function getEditUrl($id)
    {
        return $this->getUrl('employee/index/edit', ['id' => $id]);
    }

    public function getDeleteUrl($id)
    {
        return $this->getUrl('employee/index/delete', ['id' => $id]);
    }

    public function getViewUrl($id)
    {
        return $this->getUrl('employee/index/view', ['id' => $id]);
    }
}
