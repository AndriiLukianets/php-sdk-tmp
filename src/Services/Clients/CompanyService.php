<?php

declare(strict_types=1);

namespace Upmind\Sdk\Services\Clients;

use Upmind\Sdk\Data\ApiResponse;
use Upmind\Sdk\Data\QueryParams;
use Upmind\Sdk\Data\Services\CreateCompanyParams;
use Upmind\Sdk\Data\Services\UpdateCompanyParams;
use Upmind\Sdk\Services\AbstractService;

/**
 * Service for managing client companies.
 */
class CompanyService extends AbstractService
{
    private const COMPANIES_URI = '/api/admin/clients/{client_id}/companies';
    private const COMPANY_URI = '/api/admin/clients/{client_id}/companies/{company_id}';

    /**
     * Create a new company.
     */
    public function createCompany(string $clientId, CreateCompanyParams $bodyParams): ApiResponse
    {
        return $this->api->post(
            $this->fillPathParams(self::COMPANIES_URI, ['client_id' => $clientId]),
            $bodyParams
        );
    }

    /**
     * Update an existing company.
     */
    public function updateCompany(string $clientId, string $companyId, UpdateCompanyParams $bodyParams): ApiResponse
    {
        return $this->api->put(
            $this->fillPathParams(self::COMPANY_URI, ['client_id' => $clientId, 'company_id' => $companyId]),
            $bodyParams
        );
    }

    /**
     * Get a list of companies for a client.
     */
    public function listCompanies(string $clientId, ?QueryParams $queryParams = null): ApiResponse
    {
        return $this->api->get(
            $this->fillPathParams(self::COMPANIES_URI, ['client_id' => $clientId]),
            $queryParams
        );
    }

    /**
     * Get a single company.
     */
    public function getCompany(string $clientId, string $companyId, ?QueryParams $queryParams = null): ApiResponse
    {
        return $this->api->get(
            $this->fillPathParams(self::COMPANY_URI, ['client_id' => $clientId, 'company_id' => $companyId]),
            $queryParams
        );
    }

    /**
     * Delete a client's company.
     */
    public function deleteCompany(string $clientId, string $companyId): ApiResponse
    {
        return $this->api->delete(
            $this->fillPathParams(self::COMPANY_URI, ['client_id' => $clientId, 'company_id' => $companyId]),
        );
    }
}
