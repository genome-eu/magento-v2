<?php

declare(strict_types=1);

namespace Genome\Payment\Model\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Genome Handler class
 * @package Genome\Payment\Model\Logger
 */
class Handler extends Base
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = Logger::DEBUG;

    /**
     * File name
     *
     * @var string
     */
    protected $fileName = '/var/log/genome_payment.log';
}
