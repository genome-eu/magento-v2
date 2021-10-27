<?php

declare(strict_types=1);

namespace Genome\Payment\ViewModel;

use Exception;
use Genome\Lib\Exception\GeneralGenomeException;
use Genome\Lib\Model\RenderableInterface;
use Genome\Payment\Gateway\Config\Config;
use Genome\Payment\Gateway\Helper\PrepareProductHelper;
use Genome\Payment\Gateway\Helper\PrepareUserHelper;
use Genome\Payment\Model\AuthorizeByToken;
use Genome\Payment\Model\TokenFactory;
use Genome\Payment\Model\TokenRepository;
use Genome\Scriney;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Payment\Gateway\Data\OrderAdapterInterface;
use Psr\Log\LoggerInterface as Logger;

/**
 * Genome AbstractIframe abstract class
 */
abstract class AbstractIframe implements ArgumentInterface
{
    /**
     * @var Scriney
     */
    private $scriney;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var PrepareUserHelper
     */
    private $userHelper;

    /**
     * @var PrepareProductHelper
     */
    private $productHelper;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var TokenFactory
     */
    protected $tokenFactory;

    /**
     * @var TokenRepository
     */
    private $tokenRepository;

    /**
     * @var AuthorizeByToken
     */
    private $authorizeToken;

    /**
     * @param Config $config
     * @param Logger $logger
     * @param UrlInterface $urlBuilder
     * @param PrepareUserHelper $userHelper
     * @param PrepareProductHelper $productHelper
     * @param ManagerInterface $messageManager
     * @param TokenFactory $tokenFactory
     * @param TokenRepository $tokenRepository
     * @param AuthorizeByToken $authorizeToken
     */
    public function __construct(
        Config               $config,
        Logger               $logger,
        UrlInterface         $urlBuilder,
        PrepareUserHelper    $userHelper,
        PrepareProductHelper $productHelper,
        ManagerInterface     $messageManager,
        TokenFactory         $tokenFactory,
        TokenRepository      $tokenRepository,
        AuthorizeByToken     $authorizeToken
    )
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->urlBuilder = $urlBuilder;
        $this->userHelper = $userHelper;
        $this->productHelper = $productHelper;
        $this->messageManager = $messageManager;
        $this->tokenFactory = $tokenFactory;
        $this->tokenRepository = $tokenRepository;
        $this->authorizeToken = $authorizeToken;
    }

    /**
     * @return OrderAdapterInterface
     */
    abstract protected function getOrder(): OrderAdapterInterface;

    /**
     * @param string $token
     * @return string
     */
    abstract protected function getSuccessUrl(string $token): string;

    /**
     * @param string $token
     * @return string
     */
    abstract protected function getDeclineUrl(string $token): string;

    /**
     * @return RenderableInterface
     * @throws GeneralGenomeException
     * @throws Exception
     */
    public function buildIframe()
    {
        $this->initGenomeConfig();

        $order = $this->getOrder();
        $billingAddress = $order->getBillingAddress();
        if (is_null($order->getBillingAddress())) {
            throw new Exception(
                'Billing Address does not exist.'
            );
        }

        $customerId = $order->getCustomerId() ?? $billingAddress->getEmail();
        $customerIdToken = (int)$customerId !== 0 ? (int)$customerId : null;
        try {
            $token = $this->tokenFactory->create();
            $token->setToken($this->authorizeToken->generateToken())
                ->setCustomerId($customerIdToken)
                ->setOrderId((int)$order->getId());
            $this->tokenRepository->save($token);

            return $this->scriney
                ->buildButton((string)$customerId)
                ->setSuccessReturnUrl($this->getSuccessUrl($token->getToken()))
                ->setDeclineReturnUrl($this->getDeclineUrl($token->getToken()))
                ->setUserInfo($this->userHelper->prepareUserProfile($order))
                ->setCustomProducts($this->productHelper->getCustomProducts($order))
                ->buildFrame($this->config->getIframeHeight(), $this->config->getIframeWidth());

        } catch (Exception $e) {
            $this->logger->debug($e);
            $this->messageManager->addErrorMessage(
                __('Something went wrong while payment iframe initiation.')
            );
            throw $e;
        }
    }

    /**
     * @throws GeneralGenomeException
     */
    public function initGenomeConfig()
    {
        $logger = null;
        if ($this->config->isDebugModeEnabled()) {
            $logger = $this->logger;
        }
        $public = $this->config->getPublicKey();
        $private = $this->config->getPrivateKey();
        $this->scriney = new Scriney($public, $private, $logger);
    }

    /**
     * @param string $token
     * @return array
     */
    protected function getRouteParams(string $token): array
    {
        return ['_current' => true, '_use_rewrite' => true, '_query' => ['token' => $token]];
    }
}
