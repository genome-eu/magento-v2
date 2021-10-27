<?php

declare(strict_types=1);

namespace Genome\Payment\Model;

use Genome\Payment\Api\Data\TokenSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class TokenSearchResults extends SearchResults implements TokenSearchResultsInterface
{

}
