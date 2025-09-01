<?php
namespace Vendor\Feedback\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class Edit extends Template
{
    protected $registry;

    public function __construct(Template\Context $context, Registry $registry, array $data = [])
    {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getFeedback()
    {
        return $this->registry->registry('current_feedback');
    }

    public function getSaveUrl()
    {
        return $this->getUrl('feedback/index/save');
    }
}
    