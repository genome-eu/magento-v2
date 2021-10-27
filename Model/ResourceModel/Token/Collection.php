<?php

declare(strict_types=1);

namespace Genome\Payment\Model\ResourceModel\Token;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(\Genome\Payment\Model\Token::class, \Genome\Payment\Model\ResourceModel\Token::class);
    }
}
