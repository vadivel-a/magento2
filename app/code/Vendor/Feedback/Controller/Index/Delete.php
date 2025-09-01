<?php
namespace Vendor\Feedback\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Vendor\Feedback\Model\FeedbackFactory;

class Delete extends Action
{
    protected $feedbackFactory;

    public function __construct(Context $context, FeedbackFactory $feedbackFactory)
    {
        $this->feedbackFactory = $feedbackFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $feedback = $this->feedbackFactory->create()->load($id);

        if ($feedback->getId()) {
            $feedback->delete();
            $this->messageManager->addSuccessMessage(__('Feedback deleted.'));
        } else {
            $this->messageManager->addErrorMessage(__('Feedback not found.'));
        }

        return $this->_redirect('feedback');
    }
}
