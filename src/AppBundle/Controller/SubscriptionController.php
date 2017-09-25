<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscription;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Subscription controller.
 */
class SubscriptionController extends Controller
{
    /**
     * Lists all subscription entities.
     *
     * @Route("/", name="subscription_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $subscriptions = $em->getRepository('AppBundle:Subscription')->findAll();

        return $this->render('@App/subscription/index.html.twig', array(
            'subscriptions' => $subscriptions,
        ));
    }

    /**
     * Creates a new subscription entity.
     *
     * @Route("/new", name="subscription_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $subscription = new Subscription();
        $form = $this->createForm('AppBundle\Form\SubscriptionType', $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscription);
            $em->flush();

            return $this->redirectToRoute('subscription_show', array('id' => $subscription->getId()));
        }

        return $this->render('@App/subscription/new.html.twig', array(
            'subscription' => $subscription,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subscription entity.
     *
     * @Route("/{id}", name="subscription_show")
     * @Method("GET")
     */
    public function showAction(Subscription $subscription)
    {
        $deleteForm = $this->createDeleteForm($subscription);
        $flashBag = $this->get('session')->getFlashBag();

        return $this->render('@App/subscription/show.html.twig', array(
            'subscription' => $subscription,
            'delete_form' => $deleteForm->createView(),
            'messages' => $flashBag->get('message'),
            'errors' => $flashBag->get('error'),
        ));
    }

    /**
     * Displays a form to edit an existing subscription entity.
     *
     * @Route("/{id}/edit", name="subscription_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Subscription $subscription)
    {
        $deleteForm = $this->createDeleteForm($subscription);
        $editForm = $this->createForm('AppBundle\Form\SubscriptionType', $subscription);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subscription_show', array('id' => $subscription->getId()));
        }

        return $this->render('@App/subscription/edit.html.twig', array(
            'subscription' => $subscription,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Pay subscription via Credit Card.
     *
     * @Route("/active/{id}", name="subscription_payment")
     * @Method({"GET", "POST"})
     */
    public function activeSubscription(Request $request, Subscription $subscription)
    {
        $PaymentForm = $this->createForm('AppBundle\Form\CreditCardType', null, [
            'card_type' => $request->get('appbundle_credit_card')['cardType'] ?? 'INVALID',
        ]);

        $PaymentForm->handleRequest($request);

        if ($PaymentForm->isSubmitted() && $PaymentForm->isValid()) {
            if ($this->get('app.subscription')->activeSubscriptionById($subscription->getId())) {
                $this->get('session')->getFlashBag()->add('message', 'Subscription Activated');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Subscription can not be activated!');
            }

            return $this->redirectToRoute('subscription_show', ['id' => $subscription->getId()]);
        }

        return $this->render('@App/subscription/activate.html.twig', [
            'form' => $PaymentForm->createView(),
            'subscription' => $subscription,
        ]);
    }

    /**
     * Deletes a subscription entity.
     *
     * @Route("/{id}", name="subscription_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Subscription $subscription)
    {
        $form = $this->createDeleteForm($subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subscription);
            $em->flush();
        }

        return $this->redirectToRoute('subscription_index');
    }

    /**
     * Creates a form to delete a subscription entity.
     *
     * @param Subscription $subscription The subscription entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Subscription $subscription)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subscription_delete', array('id' => $subscription->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
