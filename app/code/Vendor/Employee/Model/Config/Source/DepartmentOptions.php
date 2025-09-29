<?php
namespace Vendor\Employee\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class DepartmentOptions implements OptionSourceInterface
{

    public function toOptionArray()
    {
        return [
            'hr'         => __('Human Resources'),
            'finance'    => __('Finance'),
            'sales'      => __('Sales'),
            'support'    => __('Support'),
            'dev'        => __('Development'),
            'ops'        => __('Operations'),
            'sec'        => __('Security'),
            'admin'      => __('Administration'),
            'networking' => __('Networking'),
        ];
    }
}
