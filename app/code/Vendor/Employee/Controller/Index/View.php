<?php
namespace Vendor\Employee\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Vendor\Employee\Model\EmployeeFactory;
use Magento\Framework\Registry;

class View extends Action
{
    /**
     * @var EmployeeFactory
     */
    protected $employeeFactory;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Constructor
     *
     * @param Context $context
     * @param EmployeeFactory $employeeFactory
     * @param ResultFactory $resultFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        EmployeeFactory $employeeFactory,
        ResultFactory $resultFactory,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->employeeFactory = $employeeFactory;
        $this->resultFactory = $resultFactory;
        $this->registry = $registry;
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $employee = $this->employeeFactory->create()->load($id);

        if (!$employee->getId()) {
            $this->messageManager->addErrorMessage(__('Employee not found.'));
            return $this->resultRedirectFactory->create()->setPath('employee');
        }

        // Register employee object
        $this->registry->register('current_employee', $employee);

        // Register multiple dynamic values
        $dynamicData = [
            'extra_info'   => 'Loaded at ' . date('Y-m-d H:i:s'),
            'custom_note'  => 'This employee profile is dynamically generated.',
            'viewer_ip'    => $this->getRequest()->getClientIp(),
            'page_label'   => 'Employee Details Page'
        ];

        foreach ($dynamicData as $key => $value) {
            $this->registry->register($key, $value);
        }

        // Prepare result page
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->set(__('Employee Details'));
        return $resultPage;
    }
}
