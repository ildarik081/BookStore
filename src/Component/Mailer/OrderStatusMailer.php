<?php

namespace App\Component\Mailer;

use App\Component\Exception\MailerException;
use App\Component\Utils\Aliases;
use App\Component\Utils\Enum\OrderStatusEnum;
use App\Entity\HistoryOrderStatus;
use App\Entity\Image;
use App\Entity\Order;
use DateTime;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class OrderStatusMailer
{
    private const PATH_TEMPLATE_NEW = '/Email/OrderStatus/new.html.twig';
    private const PATH_TEMPLATE_IN_WORK = '/Email/OrderStatus/inWork.html.twig';
    private const PATH_TEMPLATE_COMPLETED = '/Email/OrderStatus/completed.html.twig';

    public function __construct(
        private readonly Environment $twig,
        private readonly MailerInterface $mailer,
        private readonly string $emailFrom
    ) {
    }

    public function sendNotify(HistoryOrderStatus $historyOrderStatus): void
    {
        try {
            match ($historyOrderStatus->getStatus()->getCode()) {
                OrderStatusEnum::New->value => $this->sendNew($historyOrderStatus),
                OrderStatusEnum::InWork->value => $this->sendInWork($historyOrderStatus),
                OrderStatusEnum::Completed->value => $this->sendCompleted($historyOrderStatus)
            };
        } catch (TransportExceptionInterface | LoaderError | RuntimeError | RuntimeError $exception) {
            throw new MailerException(
                message: 'Ошибка отправки уведомления (orderId: ' . $historyOrderStatus->getOrder()?->getId()
                    . ', statusCode: ' . $historyOrderStatus->getStatus()->getCode() .') ' . $exception->getMessage(),
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'SEND_MAIL_ERROR',
                logLevel: LogLevel::CRITICAL
            );
        }
    }

    /**
     * Отправить уведомление для статуса New
     *
     * @param HistoryOrderStatus $historyOrderStatus
     * @return void
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
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
                    ->load(self::PATH_TEMPLATE_NEW)
                    ->render(
                        [
                            'storeName' => Aliases::STORE_NAME,
                            'siteUrl' => Aliases::SITE_URL,
                            'year' => (new DateTime())->format('Y'),
                            'number' => $historyOrderStatus->getOrder()?->getId(),
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
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
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
                    ->load(self::PATH_TEMPLATE_IN_WORK)
                    ->render(
                        [
                            'storeName' => Aliases::STORE_NAME,
                            'siteUrl' => Aliases::SITE_URL,
                            'year' => (new DateTime())->format('Y'),
                            'number' => $historyOrderStatus->getOrder()?->getId(),
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
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
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
                    ->load(self::PATH_TEMPLATE_COMPLETED)
                    ->render(
                        [
                            'storeName' => Aliases::STORE_NAME,
                            'siteUrl' => Aliases::SITE_URL,
                            'year' => (new DateTime())->format('Y'),
                            'number' => $historyOrderStatus->getOrder()?->getId(),
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
