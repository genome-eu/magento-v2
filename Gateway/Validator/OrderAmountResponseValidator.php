<?php

declare(strict_types=1);

namespace Genome\Payment\Gateway\Validator;

use Genome\Payment\Gateway\Config\Config;
use Genome\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Validator\AbstractValidator;
use Magento\Payment\Gateway\Validator\ResultInterface;
use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;
use Magento\Sales\Api\OrderRepositoryInterface as OrderRepository;

/**
 * Genome OrderAmountResponseValidator class
 */
class OrderAmountResponseValidator extends AbstractValidator
{
    /**
     * @var SubjectReader
     */
    private $subjectReader;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @param SubjectReader $subjectReader
     * @param OrderRepository $orderRepository
     * @param ResultInterfaceFactory $resultFactory
     */
    public function __construct(
        SubjectReader          $subjectReader,
        OrderRepository        $orderRepository,
        ResultInterfaceFactory $resultFactory
    )
    {
        $this->subjectReader = $subjectReader;
        $this->orderRepository = $orderRepository;
        parent::__construct($resultFactory);
    }

    /**
     * @param array $validationSubject
     * @return ResultInterface
     */
    public function validate(array $validationSubject): ResultInterface
    {
        $paymentDO = $this->subjectReader->readPayment($validationSubject);

        $orderId = $paymentDO->getOrder()->getId();
        $order = $this->orderRepository->get($orderId);
        $isValid = $order->getBaseTotalDue() < Config::GENOME_ORDER_AMOUNT;

        return $this->createResult(
            $isValid,
            !$isValid ? [__('Wrong order amount')] : []
        );
    }

}
