<?php
namespace Vendor\Employee\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Vendor\Employee\Block\Adminhtml\Edit;

class Department extends Column
{
    protected $editBlock;

    public function __construct(
        \Magento\Framework\View\Element\UIComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        Edit $editBlock,
        array $components = [],
        array $data = []
    ) {
        $this->editBlock = $editBlock;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $options = $this->editBlock->getDepartmentOptions();

        foreach ($dataSource['data']['items'] as &$item) {
            $code = $item['department'] ?? null;
            if ($code && isset($options[$code])) {
                $item['department'] = $options[$code];
            }
        }

        return $dataSource;
    }
}
