<?php

declare(strict_types=1);

namespace Genome\Payment\Gateway\Validator;

use Genome\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Validator\AbstractValidator;
use Magento\Payment\Gateway\Validator\ResultInterface;
use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;

/**
 * Genome OrderCurrencyResponseValidator class
 */
class OrderCurrencyResponseValidator extends AbstractValidator
{
    /**
     * @var SubjectReader
     */
    private $subjectReader;

    public function __construct(
        SubjectReader          $subjectReader,
        ResultInterfaceFactory $resultFactory
    )
    {
        $this->subjectReader = $subjectReader;
        parent::__construct($resultFactory);
    }

    /**
     * @param array $validationSubject
     * @return ResultInterface
     */
    public function validate(array $validationSubject): ResultInterface
    {
        $currency = $this->subjectReader->readCurrency($validationSubject);
        $paymentDO = $this->subjectReader->readPayment($validationSubject);
        $order = $paymentDO->getOrder();

        $isValid = $currency === $order->getCurrencyCode();

        return $this->createResult(
            $isValid,
            !$isValid ? [__('Wrong order currency')] : []
        );
    }

}
