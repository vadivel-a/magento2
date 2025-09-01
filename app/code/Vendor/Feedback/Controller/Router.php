<?php
namespace Vendor\Feedback\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\RequestInterface;
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
        $pathInfo = trim($request->getPathInfo(), '/'); // e.g. feedback/add
        $parts = explode('/', $pathInfo);

        // Only process "feedback/*"
        if ($parts[0] !== 'feedback') {
            return null; // let Magento handle others
        }

        // If format is /feedback/index/... → let Magento handle it
        if (isset($parts[1]) && $parts[1] === 'index') {
            return null;
        }

        // Short format: /feedback/add, /feedback/edit/1, /feedback/delete/1
        $action = $parts[1] ?? 'index';

        $request->setModuleName('feedback')
            ->setControllerName('index')
            ->setActionName($action);

        // Handle ID if present: /feedback/edit/1
        if (isset($parts[2])) {
            $request->setParam('id', $parts[2]);
        }

        return $this->actionFactory->create(
            \Magento\Framework\App\Action\Forward::class,
            ['request' => $request]
        );
    }
}
