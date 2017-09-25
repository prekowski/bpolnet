<?php

namespace AppBundle\Service;

use AppBundle\Entity\Subscription;
use Doctrine\ORM\EntityManager;

class SubscriptionService
{
    private $entityManager;
    private $mailer;

    /**
     * @param EntityManager $entityManager
     * @param \Swift_Mailer $mailer
     */
    public function __construct(EntityManager $entityManager, \Swift_Mailer $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    /**
     * Cancel subscription by id.
     *
     * @param int $subscriptionId
     *
     * @return bool
     */
    public function cancelSubscription(int $subscriptionId)
    {
        $subscription = $this->entityManager->getRepository(Subscription::class)->find($subscriptionId);
        if ($subscription instanceof Subscription) {
            $subscription->setStatus(Subscription::STATUS_CANCELED);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Get subscription by id and set status on active.
     *
     * @param int $subscriptionId
     *
     * @return bool
     */
    public function activeSubscriptionById(int $subscriptionId) : bool
    {
        $subscription = $this->entityManager->getRepository(Subscription::class)->find($subscriptionId);

        if ($subscription instanceof Subscription) {
            $subscription->setStatus(Subscription::STATUS_ACTIVE);
            $subscription->setStartedAt(new \DateTime());

            // @todo Add Payment data

            $this->entityManager->flush();

            $this->sendNotification($subscription);

            return true;
        }

        return false;
    }

    /**
     * @param Subscription $subscription
     */
    private function sendNotification(Subscription $subscription)
    {
        //@todo Send Email to user
    }
}
