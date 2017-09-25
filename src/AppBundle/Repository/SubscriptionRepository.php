<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SubscriptionRepository extends EntityRepository
{
    public function findByNoValidPaymentInLastDays($days = 7)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT s FROM AppBundle:Subscription s 
                    LEFT JOIN s.payments p
                    WHERE s.startedAt < :date AND p.id IS NULL')
            ->setParameter('date', (new \DateTime())->sub(new \DateInterval('P' . $days . 'D')))
            ->getResult();
    }
}
