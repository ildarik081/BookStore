<?php

namespace App\Command;

use App\Repository\CartRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:remove-empty-cart',
    description: 'Удалить пустые корзины',
)]
class RemoveEmptyCartCommand extends Command
{
    public function __construct(private readonly CartRepository $cartRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $carts = $this->cartRepository->findAll();

        foreach ($carts as $cart) {
            if (count($cart->getCartProducts()) === 0) {
                $inputOutput->info('Корзина с идентификатором ' . $cart->getId() . ' удалена');
                $this->cartRepository->remove($cart, true);
            }
        }

        $inputOutput->success('Пустые корзины удалены');

        return Command::SUCCESS;
    }
}
