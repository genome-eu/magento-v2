<?php

declare(strict_types=1);

namespace Genome\Payment\Model;

use Exception;
use Genome\Payment\Gateway\Config\Config;
use Psr\Log\LoggerInterface as Logger;

/**
 * Genome CallbackDataMapper class
 */
class CallbackDataMapper
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger
    )
    {
        $this->logger = $logger;
    }

    /**
     * @param array $requestParams
     * @return array
     * @throws Exception
     */
    public function convert(array $requestParams): array
    {
        try {
            return [
                Config::GENOME_USER_ID => $requestParams['uniqueUserId'] ?? null,
                Config::GENOME_TRANSACTION_ID => $requestParams['uniqueTransactionId'] ?? null,
                Config::GENOME_ORDER_CURRENCY => $requestParams['currency'] ?? null,
                Config::GENOME_ORDER_AMOUNT => $requestParams['totalAmount'] ?? null,
                Config::GENOME_ORDER_STATUS => $requestParams['status'] ?? null,
                Config::GENOME_RESPONSE_MESSAGE => $requestParams['message'] ?? null,
                Config::GENOME_BILL_TOKEN => $requestParams['billToken'] ?? null,
                Config::CC_TYPE => $requestParams['customParameters']['custom_card_brand'] ?? null,
                Config::CC_LAST4 => $requestParams['customParameters']['custom_card_last'] ?? null,
                Config::CC_EXP_MONTH => $requestParams['customParameters']['custom_card_expiration_month'] ?? null,
                Config::CC_EXP_YEAR => $requestParams['customParameters']['custom_card_expiration_year'] ?? null
            ];

        } catch (Exception $e) {
            $this->logger->alert($e);
            throw $e;
        }
    }
}
