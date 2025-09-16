<?php
namespace Vendor\Student\Controller\Delete;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('id'); // Grab ID from /id/5
        if (!$id) {
            echo "No ID provided!";
            return;
        }
        echo "Delete Student ID: " . $id;
        exit;
    }
}
