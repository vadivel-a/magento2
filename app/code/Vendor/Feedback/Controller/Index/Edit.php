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
        if (!$data) {
            return $this->_redirect('feedback');
        }

        $id = isset($data['id']) ? (int)$data['id'] : null;
        $feedback = $this->feedbackFactory->create();

        if ($id) {
            $feedback->load($id);
        }

        $feedback->setData($data);
        $feedback->save();

        $this->messageManager->addSuccessMessage(__('Feedback saved.'));
        return $this->_redirect('feedback');
    }
}
