<?php

declare(strict_types=1);

namespace Genome\Payment\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Genome Token class
 */
class Token extends AbstractDb
{
    /**
     * @param Context $context
     * @param string|null $connectionName
     */
    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init('genome_tokens', 'id');
    }

}
