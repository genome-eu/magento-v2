<?php

declare(strict_types=1);

namespace Genome\Payment\Model\Checkout;

use Genome\Payment\Gateway\Config\Config;
use Magento\Checkout\Model\ConfigProviderInterface;

/**
 * Class GenomeConfigProvider
 * @package Genome\Payment\Model\Checkout
 */
class GenomeConfigProvider implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        return [
            'payment' => [
                Config::CODE => [
                    'genomeRedirectUrl' => Config::PATH_REDIRECT_URL,
                    'ccVaultCode' => Config::CC_VAULT_CODE
                ]
            ]
        ];
    }
}
