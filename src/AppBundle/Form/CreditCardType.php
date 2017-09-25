<?php

namespace AppBundle\Form;

use AppBundle\Entity\CreditCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Regex;

class CreditCardType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cardType = $options['card_type'];
        $allowedCardType = CreditCard::getAllowedCardType();
        $arrayLabel = array_flip($allowedCardType);

        $builder
            ->add('cardNumber', TextType::class, [
                'constraints' => [
                    new CardScheme([
                        'schemes' => CreditCard::getValidatorByType($cardType),
                        'message' => 'Invalid card number' . (isset($arrayLabel[$cardType]) ? ' for ' . $arrayLabel[$cardType] . ' card.' : ''),
                    ])
                ],
            ])
            ->add('cvvNumber', TextType::class, [
                'empty_data' => '000',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]{3}$/'
                    ])
                ],
            ])
            ->add('cardType', ChoiceType::class, [
                'placeholder' => 'Choose your card type',
                'choices' => $allowedCardType,
                'constraints' => [
                    new Choice([
                        'choices' => $allowedCardType,
                    ])
                ],
            ])
            ->add('submit', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CreditCard',
            'card_type' => 'INVALID',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_credit_card';
    }
}
