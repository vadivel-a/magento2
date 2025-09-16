<?php
namespace Vendor\Student\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    public function execute()
    {
        echo "Student List Page (short URL: /student)";
        exit;
    }
}
