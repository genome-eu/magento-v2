<?php

declare(strict_types=1);

namespace Genome\Payment\Gateway\Helper;

use Genome\Lib\Exception\GeneralGenomeException;
use Genome\Lib\Model\FixedProduct;
use Magento\Payment\Gateway\Data\OrderAdapterInterface;

class PrepareProductHelper extends ScrineyHelper
{
    /**
     * @param OrderAdapterInterface $order
     * @return FixedProduct[]
     * @throws GeneralGenomeException
     */
    public function getCustomProducts(OrderAdapterInterface $order): array
    {
        $currency = $order->getCurrencyCode();
        $orderId = $order->getOrderIncrementId();
        $totalAmount = $order->getGrandTotalAmount();

        return [
            new FixedProduct(
                $orderId,
                'Order id #' . $orderId,
                (float)$totalAmount,
                $currency
            )
        ];
    }

    /**
     * @param OrderAdapterInterface $order
     * @return FixedProduct
     * @throws GeneralGenomeException
     */
    public function getCustomProduct(OrderAdapterInterface $order): FixedProduct
    {
        $currency = $order->getCurrencyCode();
        $orderId = $order->getOrderIncrementId();
        $totalAmount = $order->getGrandTotalAmount();

        return
            new FixedProduct(
                $orderId,
                'Order id #' . $orderId,
                (float)$totalAmount,
                $currency
            );
    }
}
