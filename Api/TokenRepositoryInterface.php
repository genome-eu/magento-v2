<?php

declare(strict_types=1);

namespace Genome\Payment\Api;

use Genome\Payment\Api\Data\TokenInterface;
use Genome\Payment\Api\Data\TokenSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Genome TokenRepositoryInterface interface
 */
interface TokenRepositoryInterface
{
    /**
     * @param string $token
     * @return TokenInterface
     */
    public function getByToken(string $token): TokenInterface;

    /**
     * @param TokenInterface $token
     * @return TokenInterface
     */
    public function save(TokenInterface $token): TokenInterface;

    /**
     * @param TokenInterface $token
     * @return bool
     */
    public function delete(TokenInterface $token): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TokenSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TokenSearchResultsInterface;

}
