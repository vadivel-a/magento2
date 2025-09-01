<?php
namespace Vendor\Feedback\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Vendor\Feedback\Model\FeedbackFactory;

class Save extends Action
{
    protected $feedbackFactory;

    public function __construct(Context $context, FeedbackFactory $feedbackFactory)
    {
        $this->feedbackFactory = $feedbackFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            try {
                $feedback = $this->feedbackFactory->create();
                $feedback->setData($data);
                $feedback->save();

                $this->messageManager->addSuccessMessage(__('Feedback submitted successfully.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error while saving feedback.'));
            }
        }
        return $this->_redirect('feedback/index/index');
    }
}
