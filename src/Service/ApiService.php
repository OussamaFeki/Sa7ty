<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApiService
{
    private $client;
    private $logger;
    private $urlGenerator;

    public function __construct(HttpClientInterface $client, LoggerInterface $logger, UrlGeneratorInterface $urlGenerator)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->urlGenerator = $urlGenerator;
    }

    public function getDiseasesBySymptoms(array $symptoms): array
    {
        try {
            $response = $this->client->request(
                'POST',
                'http://localhost:5000/diagnose',
                [
                    'json' => ['symptoms' => $symptoms]
                ]
            );

            // Check if the response status code is 200
            if ($response->getStatusCode() === 200) {
                return $response->toArray();
            } else {
                // Log non-200 status code
                $this->logger->error('Unexpected status code received from the API.', [
                    'status_code' => $response->getStatusCode(),
                    'body' => $response->getContent(false)
                ]);
            }
        } catch (ClientException $e) {
            $this->logger->error('Client exception when calling API.', ['exception' => $e]);
        } catch (ServerException $e) {
            $this->logger->error('Server exception when calling API.', ['exception' => $e]);
        } catch (TransportException $e) {
            $this->logger->error('Transport exception when calling API.', ['exception' => $e]);
        } catch (\Exception $e) {
            $this->logger->error('General exception when calling API.', ['exception' => $e]);
        }

        return []; // Return an empty array if the API call fails
    }

    public function getAllMedicines(): array
    {
        try {
            $response = $this->client->request('GET', $this->urlGenerator->generate('api_medicines'));

            if ($response->getStatusCode() === 200) {
                return $response->toArray();
            } else {
                $this->logger->error('Unexpected status code received from the API.', [
                    'status_code' => $response->getStatusCode(),
                    'body' => $response->getContent(false)
                ]);
            }
        } catch (\Exception $e) {
            $this->logger->error('Error fetching all medicines from the API.', ['exception' => $e]);
        }

        return []; // Return an empty array if the API call fails
    }
}
