<?php

declare(strict_types=1);

namespace Genome\Payment\Gateway\Response;

use Exception;
use Genome\Lib\Exception\GeneralGenomeException;
use Genome\Payment\Gateway\Config\Config;
use Genome\Payment\Gateway\Helper\SubjectReader;
use Genome\Scriney;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Psr\Log\LoggerInterface as Logger;

/**
 * Genome RefundHandler class
 */
class RefundHandler implements HandlerInterface
{
    /**
     * @var SubjectReader
     */
    private $subjectReader;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param SubjectReader $subjectReader
     * @param Logger $logger
     * @param Config $config
     */
    public function __construct(
        SubjectReader $subjectReader,
        Logger        $logger,
        Config        $config
    )
    {
        $this->subjectReader = $subjectReader;
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @param array $handlingSubject
     * @param array $response
     * @throws GeneralGenomeException
     */
    public function handle(array $handlingSubject, array $response)
    {
        $logger = null;
        if ($this->config->isDebugModeEnabled()) {
            $logger = $this->logger;
        }

        $paymentDO = $this->subjectReader->readPayment($handlingSubject);
        $payment = $paymentDO->getPayment();

        $order = $paymentDO->getOrder();

        $transactionId = $payment->getAdditionalInformation(Config::GENOME_TRANSACTION_ID);
        $amount = $this->subjectReader->readAmount($handlingSubject);
        $currency = $order->getCurrencyCode();

        $scriney = new Scriney($this->config->getPublicKey(), $this->config->getPrivateKey(), $logger);
        $result = $scriney->refund($transactionId, (float)$amount, $currency);
        try {
            $scriney->validateApiResult($result);
            $payment->setTransactionId($result['transactionId']);
        } catch (Exception $e) {
            $this->logger->critical($e);
        }

        $payment->setIsTransactionClosed(true);
        $payment->setShouldCloseParentTransaction(!$payment->getCreditmemo()->getInvoice()->canRefund());

    }
}
