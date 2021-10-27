<?php

declare(strict_types=1);

namespace Genome\Payment\Gateway\Config;

/**
 * Genome ConfigInterface interface
 */
interface ConfigInterface
{
    /**
     * Xml path for Genome Payment status
     *
     * @var string
     */
    const XML_PATH_GENOME_ACTIVE = 'active';

    /**
     * Xml path for Genome Payment sandbox mode
     *
     * @var string
     */
    const XML_PATH_GENOME_TEST = 'test';

    /**
     * XML path for Genome debug mode
     *
     */
    const XML_PATH_GENOME_DEBUG = 'debug';

    /**
     * XML path for Genome iframe height
     *
     * @var string
     */
    const XML_PATH_GENOME_IFRAME_HEIGHT = 'iframe_height';

    /**
     * XML path for Genome iframe width
     *
     * @var string
     */
    const XML_PATH_GENOME_IFRAME_WIDTH = 'iframe_width';

    /**
     * Test public key for Genome API
     *
     * @var string
     */
    const TEST_PUBLIC_KEY = 'test_public_key';

    /**
     * Test private key for Genome API
     *
     * @var string
     */
    const TEST_PRIVATE_KEY = 'test_private_key';

    /**
     * Public key for Genome API
     *
     * @var string
     */
    const PUBLIC_KEY = 'public_key';

    /**
     * Private key for Genome API
     *
     * @var string
     */
    const PRIVATE_KEY = 'private_key';

    /**
     * Payment method code
     *
     * @var string
     */
    const CODE = 'genome';

    /**
     * Payment Vault code
     *
     * @var string
     */
    const CC_VAULT_CODE = 'genome_cc_vault';

    /**
     * Credit card brand (MASTERCARD, VISA etc.)
     *
     * @var string
     */
    const CC_TYPE = 'card_brand';

    /**
     * Default card type
     *
     * @var string
     */
    const CC_DEFAULT_TYPE = 'default_card_type';

    /**
     * Credit card last4
     *
     * @var string
     */
    const CC_LAST4 = 'card_last4';

    /**
     * Credit card expiration year
     *
     * @var string
     */
    const CC_EXP_YEAR = 'card_expiration_year';

    /**
     * Credit card expiration month
     *
     * @var string
     */
    const CC_EXP_MONTH = 'card_expiration_month';

    /**
     * Redirect path
     *
     * @var string
     */
    const PATH_REDIRECT_URL = 'genome/iframe';

    /**
     * Genome transaction id
     *
     * @var string
     */
    const GENOME_TRANSACTION_ID = 'uniqueTransactionId';

    /**
     * The unique Id of the user in merchant’s system.
     *
     * @var string
     */
    const GENOME_USER_ID = 'uniqueUserId';

    /**
     * Genome status of the transaction.
     *
     * @var string
     */
    const GENOME_ORDER_STATUS = 'status';

    /**
     * Genome response message
     *
     * @var string
     */
    const GENOME_RESPONSE_MESSAGE = 'message';

    /**
     * Success Order status from Genome Callback
     *
     * @var string
     */
    const GENOME_ORDER_STATUS_SUCCESS = 'success';

    /**
     * Decline Order status from Genome Callback
     *
     * @var string
     */
    const GENOME_ORDER_STATUS_DECLINE = 'decline';

    /**
     * Refund Order status from Genome Callback
     *
     * @var string
     */
    const GENOME_ORDER_STATUS_REFUND = 'refunded';

    /**
     * The unique payment token which is received in callback data after a customer made the initial payment.
     *
     * @var string
     */
    const GENOME_BILL_TOKEN = 'billToken';

    /**
     * Token lifetime in seconds
     *
     * @var string
     */
    const TOKEN_LIFETIME = 'token_lifetime';

    /**
     * Check sum of callback packet
     *
     * @var string
     */
    const GENOME_TRANSACTION_CHECKSUM = 'checkSum';

    /**
     * Amount of the refund
     *
     * @var string
     */
    const GENOME_ORDER_AMOUNT = 'amount';

    /**
     *    Currency of the refund
     *
     * @var string
     */
    const GENOME_ORDER_CURRENCY = 'currency';

    /**
     * Credit Cards' types mapper key
     *
     * @var string
     */
    const KEY_CC_TYPES_MAPPER = 'cctypes_genome_mapper';

    public function isActive(?int $storeId = null): bool;

    public function isTestModeEnabled(?int $storeId = null): bool;

    public function isDebugModeEnabled(?int $storeId = null): bool;

    public function getIframeHeight(): string;

    public function getIframeWidth(): string;

    public function getPublicKey(?int $storeId = null): string;

    public function getPrivateKey(?int $storeId = null): string;

    public function getTransactionId(): string;

    public function getUserId(): string;

    public function getTransactionAmount(): int;

    public function getTransactionCurrency(): string;

    public function getCcTypesMapper(): array;

    public function getCreditCardType(string $type): string;

    public function getDefaultCardType(): string;
}
