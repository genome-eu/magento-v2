<?php

declare(strict_types=1);

namespace Genome\Payment\ViewModel;

use Genome\Payment\Gateway\Config\Config;
use Genome\Payment\Gateway\Helper\PrepareProductHelper;
use Genome\Payment\Gateway\Helper\PrepareUserHelper;
use Genome\Payment\Model\AuthorizeByToken;
use Genome\Payment\Model\TokenFactory;
use Genome\Payment\Model\TokenRepository;
use Magento\Checkout\Model\Session;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Payment\Gateway\Data\Order\OrderAdapterFactory;
use Magento\Payment\Gateway\Data\OrderAdapterInterface;
use Psr\Log\LoggerInterface as Logger;

/**
 * Genome SessionIframe class
 */
class SessionIframe extends AbstractIframe
{
    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var OrderAdapterFactory
     */
    private $orderAdapterFactory;

    /**
     * @param Session $checkoutSession
     * @param Config $config
     * @param Logger $logger
     * @param UrlInterface $urlBuilder
     * @param PrepareUserHelper $userHelper
     * @param PrepareProductHelper $productHelper
     * @param ManagerInterface $messageManager
     * @param TokenFactory $tokenFactory
     * @param TokenRepository $tokenRepository
     * @param AuthorizeByToken $authorizeToken
     * @param OrderAdapterFactory $orderAdapterFactory
     */
    public function __construct(
        Session              $checkoutSession,
        Config               $config,
        Logger               $logger,
        UrlInterface         $urlBuilder,
        PrepareUserHelper    $userHelper,
        PrepareProductHelper $productHelper,
        ManagerInterface     $messageManager,
        TokenFactory         $tokenFactory,
        TokenRepository      $tokenRepository,
        AuthorizeByToken     $authorizeToken,
        OrderAdapterFactory  $orderAdapterFactory
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->orderAdapterFactory = $orderAdapterFactory;
        parent::__construct($config, $logger, $urlBuilder, $userHelper, $productHelper, $messageManager, $tokenFactory, $tokenRepository, $authorizeToken);
    }

    /**
     * @return OrderAdapterInterface
     */
    protected function getOrder(): OrderAdapterInterface
    {
        $order = $this->checkoutSession->getLastRealOrder();

        return $this->orderAdapterFactory->create(
            ['order' => $order]
        );
    }

    /**
     * @param string $token
     * @return string
     */
    protected function getSuccessUrl(string $token): string
    {
        return $this->urlBuilder->getUrl('genome/redirect', $this->getRouteParams($token));
    }

    /**
     * @param string $token
     * @return string
     */
    protected function getDeclineUrl(string $token): string
    {
        return $this->urlBuilder->getUrl('genome/redirect/decline', $this->getRouteParams($token));
    }
}
