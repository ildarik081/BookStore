<?php

namespace App\Component\Mailer;

use App\Component\Utils\Aliases;
use App\Component\Utils\Enum\OrderStatusEnum;
use App\Entity\HistoryOrderStatus;
use App\Entity\Image;
use App\Entity\Order;
use DateTime;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class OrderStatusMailer
{
    public function __construct(
        private readonly Environment $twig,
        private readonly MailerInterface $mailer,
        private readonly string $emailFrom
    ) {
    }

    public function sendNotify(HistoryOrderStatus $historyOrderStatus): void
    {
        match ($historyOrderStatus->getStatus()->getCode()) {
            OrderStatusEnum::New->value => $this->sendNew($historyOrderStatus),
            OrderStatusEnum::InWork->value => $this->sendInWork($historyOrderStatus),
            OrderStatusEnum::Completed->value => $this->sendCompleted($historyOrderStatus)
        };
    }

    /**
     * Отправить уведомление для статуса New
     *
     * @param HistoryOrderStatus $historyOrderStatus
     * @return void
     */
    private function sendNew(HistoryOrderStatus $historyOrderStatus): void
    {
        $email = (new Email())
            ->from($this->emailFrom)
            ->to($historyOrderStatus->getOrder()?->getRecipient()?->getEmail())
            ->subject(OrderStatusEnum::New->getSubject($historyOrderStatus->getOrder()?->getId()))
            ->html(
                $this
                    ->twig
                    ->load('/Email/new.html.twig')
                    ->render(
                        [
                            'storeName' => Aliases::STORE_NAME,
                            'siteUrl' => Aliases::SITE_URL,
                            'year' => (new DateTime())->format('Y'),
                            'basket' => $this->createBasketArray($historyOrderStatus->getOrder()),
                            'totalPrice' => $historyOrderStatus->getOrder()?->getTotalPrice()
                        ]
                    )
            )
        ;

        $this->mailer->send($email);
    }

    /**
     * Отправить уведомление для статуса InWork
     *
     * @param HistoryOrderStatus $historyOrderStatus
     * @return void
     */
    private function sendInWork(HistoryOrderStatus $historyOrderStatus): void
    {
        $email = (new Email())
            ->from($this->emailFrom)
            ->to($historyOrderStatus->getOrder()?->getRecipient()?->getEmail())
            ->subject(OrderStatusEnum::InWork->getSubject($historyOrderStatus->getOrder()?->getId()))
            ->html(
                $this
                    ->twig
                    ->load('/Email/inWork.html.twig')
                    ->render(
                        [
                            'storeName' => Aliases::STORE_NAME,
                            'siteUrl' => Aliases::SITE_URL,
                            'year' => (new DateTime())->format('Y'),
                            'basket' => $this->createBasketArray($historyOrderStatus->getOrder()),
                            'totalPrice' => $historyOrderStatus->getOrder()?->getTotalPrice()
                        ]
                    )
            )
        ;

        $this->mailer->send($email);
    }

    /**
     * Отправить уведомление для статуса Completed
     *
     * @param HistoryOrderStatus $historyOrderStatus
     * @return void
     */
    private function sendCompleted(HistoryOrderStatus $historyOrderStatus): void
    {
        $email = (new Email())
            ->from($this->emailFrom)
            ->to($historyOrderStatus->getOrder()?->getRecipient()?->getEmail())
            ->subject(OrderStatusEnum::Completed->getSubject($historyOrderStatus->getOrder()?->getId()))
            ->html(
                $this
                    ->twig
                    ->load('/Email/completed.html.twig')
                    ->render(
                        [
                            'storeName' => Aliases::STORE_NAME,
                            'siteUrl' => Aliases::SITE_URL,
                            'year' => (new DateTime())->format('Y'),
                            'basket' => $this->createBasketArray($historyOrderStatus->getOrder()),
                            'totalPrice' => $historyOrderStatus->getOrder()?->getTotalPrice()
                        ]
                    )
            )
        ;

        $this->mailer->send($email);
    }

    private function createBasketArray(Order $order): array
    {
        $result = [];

        foreach ($order->getOrderProduct() as $product) {
            /** @var Image $image */
            $image = $product->getProduct()->getImages()->first();

            $result[] = [
                'title' => $product->getProduct()->getTitle(),
                'description' => $product->getProduct()->getDescription(),
                'author' => $product->getProduct()->getAuthor(),
                'price' => $product->getProduct()->getPrice(),
                'quantity' => $product->getQuantity(),
                'imgSrc' => $image->getPath() . $image->getFileName(),
                'imgAlt' => $image->getDescription(),
                'download' => $product->getProduct()->getUrl()
            ];
        }

        return $result;
    }
}
