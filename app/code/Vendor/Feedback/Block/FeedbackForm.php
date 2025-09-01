<?php
namespace Vendor\Feedback\Block;

use Magento\Framework\View\Element\Template;

class FeedbackForm extends Template
{
    public function getFormAction()
    {
        return $this->getUrl('feedback/index/save');
    }
}
