<?php

namespace AppBundle\Command;

use AppBundle\Entity\Subscription;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CancelSubscriptionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:cancel-subscription')
            ->setDescription('Cancel not payed subscription.')
            ->setHelp('This command cancel subscriptions which are not payed in last 7 days')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Cancel not payed subscriptions!');

        $subscriptionService = $this->getContainer()->get('app.subscription');

        $queryBuilder = $this->getContainer()
            ->get('doctrine')
            ->getRepository(Subscription::class)
            ->createQueryBuilder('s');

        $date = (new \DateTime())->sub(new \DateInterval('P7D'));

        /**
         * 4. Stwórz command, który będzie anulował subskrypcje dla których nie odnotowano płatności
         * w terminie 7 dni od daty ich końca, zakładając, że jeden miesiąc to równo 30 dni.
         *
         * Sorry, ale nie mam pojęcia co autor miał na myśli. Patrząc na tabele nie mam pojęcia do czego to przypiąć.
         * Założyłem, że datą zakończenia jest pole date w tabeli z paymentami - straszna kicha ;).
         * Jeżeli jest płatność ale data jest starsza niż 7 dni lub nie ma płatności, a data utworzenia subskrypcji jest starsza niż 7 dni
         * to o ile rekord nie jest anulowany, to go anuluje.
         */
        $subscriptions = $queryBuilder
            ->leftJoin('AppBundle\Entity\SubscriptionPayment', 'p', Join::LEFT_JOIN, 's.id = p.subscriptionId')
            ->where('p.id is not null AND p.date < :date')
            ->orWhere('p.id is null AND s.createdAt < :date')
            ->andWhere('s.status <> :status')
            ->setParameter('date', $date)
            ->setParameter('status', Subscription::STATUS_CANCELED)
            ->getQuery()
            ->getResult();

        $progressBar = new ProgressBar($output, count($subscriptions));
        $progressBar->setFormat('very_verbose');

        foreach ($subscriptions as $subscription) {
            $subscriptionService->cancelSubscription($subscription->getId());
            $progressBar->advance();
        }

        $progressBar->finish();
    }
}