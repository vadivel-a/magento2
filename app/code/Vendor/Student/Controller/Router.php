<?php
namespace Student\Module\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\Action\Redirect;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\State;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Url;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Custom\Module\Model\Routing\Entity;
use Magento\Framework\Controller\ResultFactory;

class Router implements RouterInterface {

    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Event manager
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;

    /**
     * Store manager
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Posts factory
     * @var \Custom\Module\Model\PostsFactory
     */
    protected $postsFactory;

    /**
     * Config primary
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * Url
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * Response
     * @var \Magento\Framework\App\ResponseInterface|\Magento\Framework\App\Response\Http
     */
    protected $response;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var bool
     */
    protected $dispatched;

    /**
     * @var \Custom\Module\Model\Routing\Entity[]
     */
    protected $routingEntities;

    /**
     * @param ActionFactory $actionFactory
     * @param ManagerInterface $eventManager
     * @param UrlInterface $url
     * @param State $appState
     * @param StoreManagerInterface $storeManager
     * @param ResponseInterface $response
     * @param ScopeConfigInterface $scopeConfig
     * @param array $routingEntities
     */
    public function __construct(
    ActionFactory $actionFactory, ManagerInterface $eventManager, UrlInterface $url, State $appState, StoreManagerInterface $storeManager, ResponseInterface $response, ScopeConfigInterface $scopeConfig, ResultFactory $resultFactory, array $routingEntities
    ) {
        $this->actionFactory = $actionFactory;
        $this->eventManager = $eventManager;
        $this->url = $url;
        $this->appState = $appState;
        $this->storeManager = $storeManager;
        $this->response = $response;
        $this->scopeConfig = $scopeConfig;
        $this->routingEntities = $routingEntities;
        $this->resultFactory = $resultFactory;
    }

    /**
     * Validate and Match
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request) {

        if (!$this->dispatched) {
            $urlKey = trim($request->getPathInfo(), '/');
            $origUrlKey = $urlKey;

            // START CHECK FOR URL KEY EXIST THEN ONLY PROCEED OTHERWIES NOT
            $postsURLPrefix = $this->scopeConfig->getValue('Module/posts/url_prefix', ScopeInterface::SCOPE_STORE);
            $postsURLSuffix = $this->scopeConfig->getValue('Module/posts/url_suffix', ScopeInterface::SCOPE_STORE);
            $parts = explode('/', $urlKey);

            if ($postsURLSuffix) {
                $suffix = substr($urlKey, -strlen($postsURLSuffix) - 1);
                if ($suffix != '.' . $postsURLSuffix) {
                    return false;
                }
                $urlKey = substr($urlKey, 0, -strlen($postsURLSuffix) - 1);
            }

            if (isset($parts[1])) {
                $postsIdentifier = str_replace($suffix, "", $parts[1]); // Posts URL Key
                // START CHECK FOR PREFIX & SUFFIX
                if ($parts[0] == $postsURLPrefix && $postsURLSuffix == $postsURLSuffix) {

                    // START CHECK FOR URL KEY EXIST THEN ONLY PROCEED OTHERWIES NOT
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $instance = $objectManager->get('Custom\Module\Model\ResourceModel\Posts');
                    $id = $instance->checkUrlKey($postsIdentifier, $this->storeManager->getStore()->getId());

                    if (!$id) {
                        return null;
                    }
                    // STOP CHECK FOR URL KEY EXIST THEN ONLY PROCEED OTHERWIES NOT

                    $condition = new DataObject(['url_key' => $origUrlKey, 'continue' => true]);
                    $this->eventManager->dispatch(
                            'Custom_Module_controller_router_match_before', ['router' => $this, 'condition' => $condition]
                    );

                    $origUrlKey = $condition->getUrlKey();

                    if ($condition->getRedirectUrl()) {

                        $this->response->setRedirect($condition->getRedirectUrl());
                        $request->setDispatched(true);
                        return $this->actionFactory->create(Redirect::class);
                    }

                    if (!$condition->getContinue()) {
                        return null;
                    }

                    foreach ($this->routingEntities as $entityKey => $entity) {
                        $match = $this->matchRoute($request, $entity, $origUrlKey, $origUrlKey);
                        if ($match === false) {
                            continue;
                        }
                        return $match;
                    }
                }
            }
            // END CHECK FOR PREFIX & SUFFIX
        }

        return null;
    }

    /**
     * @param RequestInterface|\Magento\Framework\HTTP\PhpEnvironment\Request $request
     * @param Entity $entity
     * @param $urlKey
     * @param $origUrlKey
     * @return bool|\Magento\Framework\App\ActionInterface|null
     */
    protected function matchRoute(RequestInterface $request, Entity $entity, $urlKey, $origUrlKey) {

        $prefix = $this->scopeConfig->getValue($entity->getPrefixConfigPath(), ScopeInterface::SCOPE_STORE);

        if ($prefix) {
            $parts = explode('/', $urlKey);
            if ($parts[0] != $prefix || count($parts) != 2) {
                return false;
            }
            $urlKey = $parts[1];
        }

        $configSuffix = $this->scopeConfig->getValue($entity->getSuffixConfigPath(), ScopeInterface::SCOPE_STORE);

        if ($configSuffix) {
            $suffix = substr($urlKey, -strlen($configSuffix) - 1);
            if ($suffix != '.' . $configSuffix) {
                return false;
            }
            $urlKey = substr($urlKey, 0, -strlen($configSuffix) - 1);
        }

        $instance = $entity->getFactory()->create();
        $id = $instance->checkUrlKey($urlKey, $this->storeManager->getStore()->getId());

        if (!$id) {
            return null;
        }

        $request->setModuleName('Module');
        $request->setControllerName($entity->getController());
        $request->setActionName($entity->getViewAction());
        $request->setParam($entity->getParam(), $id);
        $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $origUrlKey);
        $request->setDispatched(true);
        $this->dispatched = true;

        return $this->actionFactory->create(Forward::class);
    }
}