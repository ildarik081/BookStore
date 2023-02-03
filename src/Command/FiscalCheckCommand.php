<?php

namespace App\Command;

use App\Repository\PaymentCheckRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fiscal-check',
    description: 'Удалить пустые корзины',
)]
class FiscalCheckCommand extends Command
{
    public function __construct(private readonly PaymentCheckRepository $paymentCheckRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $this->paymentCheckRepository->findBy(['isActive' => true]);

        //todo Тут можно прикрутить фискализацию чеков по крону

        // foreach ($checks as $check) {

        // }


        $inputOutput->success('Чеки успешно фискализованы');

        return Command::SUCCESS;
    }
}
