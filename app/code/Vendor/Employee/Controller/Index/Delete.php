<?php
namespace Vendor\Employee\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Vendor\Employee\Model\EmployeeFactory;
use Magento\Framework\Controller\Result\RedirectFactory;

class Delete extends Action
{
    protected $employeeFactory;
    protected $resultRedirectFactory;

    public function __construct(
        Context $context,
        EmployeeFactory $employeeFactory,
        RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->employeeFactory = $employeeFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->employeeFactory->create();
                $model->load($id);
                if ($model->getId()) {
                    $model->delete();
                    $this->messageManager->addSuccessMessage(__('Employee deleted.'));
                } else {
                    $this->messageManager->addErrorMessage(__('Employee not found.'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Unable to delete.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Invalid id.'));
        }

        return $resultRedirect->setPath('employee');
    }
}
