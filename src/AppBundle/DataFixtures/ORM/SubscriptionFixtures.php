<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $subscription = new Subscription();
        $subscription->setId(1);
        $subscription->setUserId(1);
        $subscription->setSubscriptionShippingAddressId(1);
        $subscription->setSubscriptionBillingAddressId(1);
        $subscription->setStatus(Subscription::STATUS_NEW);
        $subscription->setSubscriptionPackId(5);
        $subscription->setStartedAt(null);
        $subscription->setUpdatedAt(null);
        $subscription->setCreatedAt(new \DateTime());
        $manager->persist($subscription);

        $subscription = new Subscription();
        $subscription->setId(2);
        $subscription->setUserId(2);
        $subscription->setSubscriptionShippingAddressId(2);
        $subscription->setSubscriptionBillingAddressId(2);
        $subscription->setStatus(Subscription::STATUS_ACTIVE);
        $subscription->setSubscriptionPackId(2);
        $subscription->setStartedAt(new \DateTime('2017-04-01'));
        $subscription->setUpdatedAt(null);
        $subscription->setCreatedAt(new \DateTime());
        $manager->persist($subscription);

        $subscription = new Subscription();
        $subscription->setId(3);
        $subscription->setUserId(3);
        $subscription->setSubscriptionShippingAddressId(3);
        $subscription->setSubscriptionBillingAddressId(3);
        $subscription->setStatus(Subscription::STATUS_ACTIVE);
        $subscription->setSubscriptionPackId(7);
        $subscription->setStartedAt(new \DateTime('2017-04-15'));
        $subscription->setUpdatedAt(null);
        $subscription->setCreatedAt(new \DateTime());
        $manager->persist($subscription);

        $manager->flush();
    }
}