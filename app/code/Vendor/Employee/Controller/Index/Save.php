<?php
namespace Vendor\Employee\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Vendor\Employee\Model\EmployeeFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Escaper;

class Save extends Action
{
    protected $employeeFactory;
    protected $resultRedirectFactory;
    protected $escaper;

    public function __construct(
        Context $context,
        EmployeeFactory $employeeFactory,
        RedirectFactory $resultRedirectFactory,
        Escaper $escaper
    ) {
        parent::__construct($context);
        $this->employeeFactory = $employeeFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->escaper = $escaper;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$data) {
            $this->messageManager->addErrorMessage(__('No data to save.'));
            return $resultRedirect->setPath('employee');
        }

        try {
            $id = $data['employee_id'] ?? null;
            $model = $this->employeeFactory->create();

            // Load existing employee if editing
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('Employee not found.'));
                    return $resultRedirect->setPath('employee');
                }
            }

            // Update only fields, keep entity_id intact
            $model->addData([
                'first_name'  => $this->escaper->escapeHtml($data['first_name'] ?? ''),
                'last_name'   => $this->escaper->escapeHtml($data['last_name'] ?? ''),
                'email'       => $this->escaper->escapeHtml($data['email'] ?? ''),
                'position'    => $this->escaper->escapeHtml($data['position'] ?? ''),
                'department'  => $this->escaper->escapeHtml($data['department'] ?? '')
            ]);

            $model->save();

            $this->messageManager->addSuccessMessage($id ? __('Employee updated.') : __('Employee saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Unable to save employee.'));
        }

        return $resultRedirect->setPath('employee');
    }
}
