<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubscriptionRepository")
 */
class Subscription
{
    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="subscription_shipping_address_id", type="integer", nullable=true)
     */
    private $subscriptionShippingAddressId;

    /**
     * @var integer
     *
     * @ORM\Column(name="subscription_billing_address_id", type="integer", nullable=true)
     */
    private $subscriptionBillingAddressId;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=16, nullable=false)
     */
    private $status = 'new';

    /**
     * @var integer
     *
     * @ORM\Column(name="subscription_pack_id", type="integer", nullable=false)
     */
    private $subscriptionPackId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started_at", type="datetime", nullable=true)
     */
    private $startedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SubscriptionPayment", mappedBy="subscriptions")
     */
    private $payments;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }

    public static function getStatuses() : array
    {
        return [
            'New' => self::STATUS_NEW,
            'Active' => self::STATUS_ACTIVE,
        ];
    }

    public function isActive() : bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getSubscriptionShippingAddressId()
    {
        return $this->subscriptionShippingAddressId;
    }

    /**
     * @param int $subscriptionShippingAddressId
     */
    public function setSubscriptionShippingAddressId($subscriptionShippingAddressId)
    {
        $this->subscriptionShippingAddressId = $subscriptionShippingAddressId;
    }

    /**
     * @return int
     */
    public function getSubscriptionBillingAddressId()
    {
        return $this->subscriptionBillingAddressId;
    }

    /**
     * @param int $subscriptionBillingAddressId
     */
    public function setSubscriptionBillingAddressId($subscriptionBillingAddressId)
    {
        $this->subscriptionBillingAddressId = $subscriptionBillingAddressId;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getSubscriptionPackId()
    {
        return $this->subscriptionPackId;
    }

    /**
     * @param int $subscriptionPackId
     */
    public function setSubscriptionPackId($subscriptionPackId)
    {
        $this->subscriptionPackId = $subscriptionPackId;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * @param \DateTime $startedAt
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param mixed $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }
}
