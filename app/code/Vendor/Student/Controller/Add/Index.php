<?php
namespace Vendor\Student\Controller\Add;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    public function execute()
    {
        echo "Add Student Form (short URL: /student/add)";
        exit;
    }
}
