<?php
namespace Vendor\Employee\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class View extends Template
{
    protected $registry;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getEmployee()
    {
        return $this->registry->registry('current_employee');
    }

    public function getCustomTitle()
    {
        return $this->getData('custom_title');
    }

    public function getExtraInfo()
    {
        return $this->registry->registry('extra_info');
    }

    public function getCustomNote()
    {
        return $this->registry->registry('custom_note');
    }

    public function getViewerIp()
    {
        return $this->registry->registry('viewer_ip');
    }

    public function getPageLabel()
    {
        return $this->registry->registry('page_label');
    }

}
