<?php

declare(strict_types=1);

namespace Genome\Payment\Model\Ui;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Vault\Api\Data\PaymentTokenInterface;
use Magento\Vault\Model\Ui\TokenUiComponentInterface;
use Magento\Vault\Model\Ui\TokenUiComponentProviderInterface;
use Magento\Vault\Model\Ui\TokenUiComponentInterfaceFactory;
use Genome\Payment\Gateway\Config\Config;
use Exception;

/**
 * Genome TokenUiComponentProvider class
 */
class TokenUiComponentProvider implements TokenUiComponentProviderInterface
{
    /**
     * @var TokenUiComponentInterfaceFactory
     */
    private $componentFactory;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * TokenUiComponentProvider Constructor
     *
     * @param TokenUiComponentInterfaceFactory $componentFactory
     */
    public function __construct(
        TokenUiComponentInterfaceFactory $componentFactory,
        Json $serializer
    ) {
        $this->componentFactory = $componentFactory;
        $this->serializer = $serializer;
    }

    /**
     * Get UI component for token
     * @param PaymentTokenInterface $paymentToken
     * @return TokenUiComponentInterface
     */
    public function getComponentForToken(PaymentTokenInterface $paymentToken): TokenUiComponentInterface
    {
        try {
            $jsonDetails = $this->serializer->unserialize($paymentToken->getTokenDetails());
        } catch (Exception $e){
            $jsonDetails = null;
        }

        $component = $this->componentFactory->create(
            [
                'config' => [
                    'code' => Config::CC_VAULT_CODE,
                    TokenUiComponentProviderInterface::COMPONENT_DETAILS => $jsonDetails,
                    TokenUiComponentProviderInterface::COMPONENT_PUBLIC_HASH => $paymentToken->getPublicHash()
                ],
                'name' => 'Genome_Payment/js/view/payment/method-renderer/vault'
            ]
        );

        return $component;
    }
}
