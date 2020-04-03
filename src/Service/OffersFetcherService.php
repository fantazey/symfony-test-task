<?php

namespace App\Service;

use App\Entity\{Appraisal, Car, SimilarOffer};
use Doctrine\ORM\EntityManager;

class OffersFetcherService {
    const API_HOST = '';
    const USE_MOCK_INDEX = 0;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

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
     * @param $offer
     * @param Car $car
     * @return SimilarOffer
     * @throws \Doctrine\ORM\ORMException
     */
    private function createSimilarOffer($offer, Car $car): SimilarOffer
    {
        $similarOffer = new SimilarOffer();
        $similarOffer->setPrice((int)$offer['price']);
        $similarOffer->setModel($offer['model']);
        $similarOffer->setColor($offer['color']);
        $similarOffer->setMileage((int)$offer['mileage']);
        $similarOffer->setYear($offer['year']);
        $similarOffer->setProducer($offer['producer']);
        $this->em->persist($similarOffer);
        return $similarOffer;
    }

    /**
     * @param array $data
     * @return false|float|int
     */
    private function calcMedian(array $data)
    {
        sort($data, SORT_NUMERIC);
        $len = count($data);
        if (count($data) % 2 === 0) {
            $halfLen = $len / 2;
            $median = ($data[$halfLen] + $data[$halfLen - 1]) / 2;
        } else {
            $halfLen = floor($len / 2);
            $median = $data[$halfLen];
        }
        return $median;
    }

    /**
     * @param Appraisal $appraisal
     * @param array $offers
     * @throws \Doctrine\ORM\ORMException
     */
    private function processOffers(Appraisal $appraisal, array $offers)
    {
        $prices = [];
        $mileages = [];
        $car = $appraisal->getCar();
        foreach ($offers as $offer) {
            $similarOffer = $this->createSimilarOffer($offer, $car);
            $prices[] = $similarOffer->getPrice();
            $mileages[] = $similarOffer->getMileage();
        }
        $medianPrice = $this->calcMedian($prices);
        $medianMileage = $this->calcMedian($mileages);
        $updateAppraisalType = count($offers) >= 100;
        $this->updateAppraisal($appraisal, $medianPrice, $medianMileage, $updateAppraisalType);
    }

    /**
     * @param Appraisal $appraisal
     * @param float $medianPrice
     * @param float $medianMileage
     * @param bool $updateType
     * @throws \Doctrine\ORM\ORMException
     */
    private function updateAppraisal(
        Appraisal $appraisal,
        float $medianPrice,
        float $medianMileage,
        bool $updateType
    ) {
        $baybackPrice = $medianPrice * ($medianMileage / $appraisal->getCar()->getMileage());
        $baybackPrice -= $appraisal->getRepairPrice() ?? 0;

        if ($updateType) {
            $appraisal->setType(Appraisal::CONTRACT_TYPE);
        }

        if ($appraisal->getType() === Appraisal::CONTRACT_TYPE) {
            $baybackPrice = $baybackPrice * 1.1;
        }

        $appraisal->setAveragePrice((int)$medianPrice);
        $appraisal->setBuybackPrice((int)$baybackPrice);
        $this->em->persist($appraisal);
    }

    /**
     * @param Appraisal $appraisal
     */
    public function fetchOffers(Appraisal $appraisal) {
//        $car = $appraisal->getCar();
        try {
//            $data = $this->makeRequest($car);
//            $offers = $this->parse($data);
            $offers = self::MOCK_ANSWERS[self::USE_MOCK_INDEX];
            $this->processOffers($appraisal, $offers);
            $this->em->flush();
        } catch (\Exception $e) {
            // log exception
        }
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