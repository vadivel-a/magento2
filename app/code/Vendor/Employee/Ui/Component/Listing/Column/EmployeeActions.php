<?php
namespace Vendor\Employee\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class EmployeeActions extends Column
{
    const URL_PATH_EDIT = 'employee/employee/edit'; // 👈 points to your edit controller
    const URL_PATH_DELETE = 'employee/employee/delete';
    const URL_PATH_ADD = 'employee/employee/new';

    /** @var UrlInterface */
    protected $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['employee_id'])) {
                    $item[$this->getData('name')] = [
                        'add' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_ADD,
                                ['employee_id' => $item['employee_id']]
                            ),
                            'label' => __('Add'),
                        ],
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_EDIT,
                                ['employee_id' => $item['employee_id']]
                            ),
                            'label' => __('Edit'),
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_DELETE,
                                ['employee_id' => $item['employee_id']]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete Employee'),
                                'message' => __('Are you sure you want to delete this employee?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
