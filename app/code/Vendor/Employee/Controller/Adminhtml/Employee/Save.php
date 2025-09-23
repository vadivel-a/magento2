<?php
namespace Vendor\Employee\Controller\Adminhtml\Employee;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Vendor\Employee\Model\EmployeeFactory;
use Magento\Framework\Escaper;

class Save extends Action
{
    protected $employeeFactory;
    protected $escaper;

    public function __construct(
        Action\Context $context,
        EmployeeFactory $employeeFactory,
        Escaper $escaper
    ) {
        parent::__construct($context);
        $this->employeeFactory = $employeeFactory;
        $this->escaper = $escaper;
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->messageManager->addErrorMessage(__('No data to save.'));
            return $resultRedirect->setPath('employee/employee/index');
        }

        try {
            $id = $data['employee_id'] ?? null;
            $model = $this->employeeFactory->create();

            // Load existing employee if editing
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('Employee not found.'));
                    return $resultRedirect->setPath('employee/employee/index');
                }
            }

            // Escape and assign data
            $model->addData([
                'first_name' => $this->escaper->escapeHtml($data['first_name'] ?? ''),
                'last_name'  => $this->escaper->escapeHtml($data['last_name'] ?? ''),
                'email'      => $this->escaper->escapeHtml($data['email'] ?? ''),
                'position'   => $this->escaper->escapeHtml($data['position'] ?? ''),
                'department' => $this->escaper->escapeHtml($data['department'] ?? '')
            ]);

            $model->save();

            $this->messageManager->addSuccessMessage(
                $id ? __('Employee updated.') : __('Employee saved.')
            );

            return $resultRedirect->setPath('employee/employee/index');

        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Unable to save employee.'));
            if (!empty($data['employee_id'])) {
                return $resultRedirect->setPath('employee/employee/new', ['id' => $data['employee_id']]);
            }
            return $resultRedirect->setPath('employee/employee/new');
        }
    }
}
