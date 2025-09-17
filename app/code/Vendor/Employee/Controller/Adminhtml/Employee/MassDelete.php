<?php
namespace Vendor\Employee\Controller\Adminhtml\Employee;

use Magento\Backend\App\Action;
use Vendor\Employee\Model\ResourceModel\Employee\CollectionFactory;

class MassDelete extends Action
{
    protected $collectionFactory;

    public function __construct(
        Action\Context $context,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected', []);
        if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addErrorMessage(__('Please select employees to delete.'));
        } else {
            try {
                $collection = $this->collectionFactory->create()->addFieldToFilter('employee_id', ['in' => $ids]);
                $count = 0;
                foreach ($collection as $employee) {
                    $employee->delete();
                    $count++;
                }
                $this->messageManager->addSuccessMessage(__('%1 employee(s) deleted.', $count));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error deleting employees: %1', $e->getMessage()));
            }
        }
        return $this->_redirect('employee/employee/index');
    }
}
