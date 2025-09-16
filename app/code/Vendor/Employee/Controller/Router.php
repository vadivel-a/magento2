<?php
namespace Vendor\Employee\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ActionInterface;

class Router implements RouterInterface
{
    protected $actionFactory;

    public function __construct(ActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    public function match(RequestInterface $request): ?ActionInterface
    {
        // Prevent infinite loop: if we already processed this request, skip
        if ($request->getModuleName() === 'employee' && $request->getControllerName() === 'index') {
            return null;
        }

        $pathInfo = trim($request->getPathInfo(), '/'); // e.g. employee/add
        $parts = explode('/', $pathInfo);

        // Only handle employee/*
        if ($parts[0] !== 'employee') {
            return null;
        }

        // If second part is "index", let Magento handle
        if (isset($parts[1]) && $parts[1] === 'index') {
            return null;
        }

        // Short format: /employee/add, /employee/edit/1
        $action = $parts[1] ?? 'index';

        $request->setModuleName('employee')
            ->setControllerName('index')
            ->setActionName($action)
            ->setDispatched(true); // 👈 mark request as dispatched

        // Handle ID if present: /employee/edit/1
        if (isset($parts[2])) {
            $request->setParam('id', $parts[2]);
        }

        return $this->actionFactory->create(
            \Magento\Framework\App\Action\Forward::class,
            ['request' => $request]
        );
    }
}
