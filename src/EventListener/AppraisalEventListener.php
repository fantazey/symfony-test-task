<?php

namespace App\EventListener;

use App\Entity\Appraisal;
use App\Service\OffersFetcherService;
use Doctrine\Persistence\Event\LifecycleEventArgs;
/**
 * Class AppraisalEventListener
 * @package App\EventListener
 */
class AppraisalEventListener
{
    private $offersFetcher;

    public function __construct(OffersFetcherService $offersFetcher)
    {
        $this->offersFetcher = $offersFetcher;
    }

    public function postPersist(LifecycleEventArgs $args) {
        /** @var Appraisal $appraisal */
        $appraisal = $args->getObject();
        $this->offersFetcher->fetchOffers($appraisal);
        return null;
    }
}