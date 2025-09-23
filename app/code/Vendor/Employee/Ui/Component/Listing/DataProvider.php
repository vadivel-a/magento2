<?php
namespace Vendor\Employee\Ui\Component\Listing;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Vendor\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\Api\Filter;

class DataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Apply filters from UI (search + field filters).
     */
    public function addFilter(Filter $filter)
    {
        if ($filter->getField() === 'fulltext') {
            $value = $filter->getValue();
            if ($value) {
                $this->collection->addFieldToFilter(
                    ['first_name', 'last_name', 'email'],
                    [
                        ['like' => "%$value%"],
                        ['like' => "%$value%"],
                        ['like' => "%$value%"]
                    ]
                );
            }
        } else {
            $condition = $filter->getConditionType() ?: 'eq';
            $this->collection->addFieldToFilter(
                $filter->getField(),
                [$condition => $filter->getValue()]
            );
        }
    }

    /**
     * Sorting (for backend grid columns).
     */
    public function addOrder($field, $direction)
    {
        $this->collection->setOrder($field, $direction);
    }

    /**
     * Pagination (for backend grid).
     */
    public function setLimit($offset, $size)
    {
        $this->collection->setPageSize($size);
        $this->collection->setCurPage($offset);
    }

    /**
     * Provide data to UI grid.
     */
    public function getData()
    {
        $items = [];
        foreach ($this->collection->getItems() as $item) {
            $items[] = $item->getData();
        }

        return [
            'totalRecords' => $this->collection->getSize(),
            'items'        => $items
        ];
    }
}
