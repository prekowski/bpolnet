<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\SubscriptionPayment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SubscriptionPaymentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $payment = new SubscriptionPayment();
        $payment->setId(1);
        $payment->setSubscriptionId(1);
        $payment->setChargedAmount(2400);
        $payment->setDate(new \DateTime("2017-04-01"));
        $payment->setUpdatedAt(null);
        $payment->setCreatedAt(new \DateTime());
        $manager->persist($payment);

        $payment = new SubscriptionPayment();
        $payment->setId(2);
        $payment->setSubscriptionId(2);
        $payment->setChargedAmount(1700);
        $payment->setDate(new \DateTime("2017-05-01"));
        $payment->setUpdatedAt(null);
        $payment->setCreatedAt(new \DateTime());
        $manager->persist($payment);

        $payment = new SubscriptionPayment();
        $payment->setId(3);
        $payment->setSubscriptionId(3);
        $payment->setChargedAmount(3600);
        $payment->setDate(new \DateTime("2017-04-15"));
        $payment->setUpdatedAt(null);
        $payment->setCreatedAt(new \DateTime());
        $manager->persist($payment);

        $manager->flush();
    }
}