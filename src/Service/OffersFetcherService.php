<?php

namespace App\Service;

use App\Entity\Appraisal;
use App\Entity\Car;

class OffersFetcherService {
    const API_HOST = '';
    const USE_MOCK_INDEX = 0;

    /**
     * @param Car $car
     * @return string
     */
    protected function buildQuery(Car $car): string {
        $params = [
            'model' => $car->getModel(),
            'producer' => $car->getProducer(),
            'color' => $car->getColor(),
            'year' => $car->getYear(),
            'mileage' => $car->getMileage()
        ];
        return OffersFetcherService::API_HOST . '?' . http_build_query($params);
    }

    /**
     * @param Car $car
     * @return string
     * @throws \Exception
     */
    private function makeRequest(Car $car): string {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->buildQuery($car));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'header-key' => 'test_key'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        if (!$response) {
            throw new \Exception('Fetcher API. Empty response');
        }
        return $response;
    }

    /**
     * @param string $data
     * @return array
     * @throws \Exception
     */
    protected function parse(string $data): array {
        $offers = json_decode($data);
        if (!$offers) {
            throw new \Exception(' Fetcher API. Incorrect response');
        }
        return $offers;
    }

    /**
     * @param Appraisal $appraisal
     */
    public function fetchOffers(Appraisal $appraisal): array {
        $car = $appraisal->getCar();
        try {
//            $data = $this->makeRequest($car);
//            $offers = $this->parse($data);
            $offers = self::MOCK_ANSWERS[self::USE_MOCK_INDEX];
//            $this->saveOffers($appraisal, $offers);
//            $this->updateAppraisal($appraisal);
        } catch (\Exception $e) {
            // log exception
        }
        return [];
    }

    const MOCK_ANSWERS = [
        0 => [
            0 => [
                'producer' => 'test1',
                'model' => 'test1',
                'year' => 1999,
                'mileage' => 251000,
                'color' => 'red',
                'price' => 120000
            ],
            1 => [
                'producer' => 'test1',
                'model' => 'test1',
                'year' => 1999,
                'mileage' => 100000,
                'color' => 'red',
                'price' => 400000
            ],
            2 => [
                'producer' => 'test1',
                'model' => 'test1',
                'year' => 1999,
                'mileage' => 150000,
                'color' => 'pink',
                'price' => 300000
            ],
            3 => [
                'producer' => 'test1',
                'model' => 'test1',
                'year' => 1999,
                'mileage' => 5000,
                'color' => 'red',
                'price' => 600000
            ],
            4 => [
                'producer' => 'test1',
                'model' => 'test1',
                'year' => 1999,
                'mileage' => 150000,
                'color' => 'red',
                'price' => 280000
            ]
        ],
        1 => [

        ]
    ];
}