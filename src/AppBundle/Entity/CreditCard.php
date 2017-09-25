<?php

namespace AppBundle\Entity;

class CreditCard
{
    const VISA = 'VI';
    const AMERICAN_EXPRESS = 'AE';
    CONST MASTERCARD = 'MS';

    private $cardNumber;
    private $cvvNumber;
    private $cardType;

    public static function getAllowedCardType()
    {
        return [
            'American Express' => self::AMERICAN_EXPRESS,
            'Visa' => self::VISA,
            'MasterCard' => self::MASTERCARD,
        ];
    }

    public static function getValidatorByType($type) {
        $types = [
            self::VISA => 'VISA',
            self::AMERICAN_EXPRESS => 'AMEX',
            self::MASTERCARD => 'MASTERCARD',
        ];

        return $types[$type] ?? 'INVALID';
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param mixed $cardNumber
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @return mixed
     */
    public function getCvvNumber()
    {
        return $this->cvvNumber;
    }

    /**
     * @param mixed $cvvNumber
     */
    public function setCvvNumber($cvvNumber)
    {
        $this->cvvNumber = $cvvNumber;
    }

    /**
     * @return mixed
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @param mixed $cardType
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
    }
}
