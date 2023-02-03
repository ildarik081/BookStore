<?php

namespace App\Component\Factory;

use App\Entity\CartProduct;
use App\Entity\CheckType;
use App\Entity\HistoryOrderStatus;
use App\Entity\Image;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\OrderStatus;
use App\Entity\Payment;
use App\Entity\PaymentCheck;
use App\Entity\PaymentType;
use App\Entity\Product;
use App\Entity\Recipient;
use App\Entity\Transaction;
use Symfony\Component\Uid\Uuid;

class EntityFactory
{
    /**
     * Собрать сущность CartProduct
     *
     * @param integer $quantity
     * @param Product $product
     * @return CartProduct
     */
    public static function createCartProduct(int $quantity, Product $product): CartProduct
    {
        $cartProduct = new CartProduct();
        $cartProduct
            ->setQuantity($quantity)
            ->setProduct($product)
        ;

        return $cartProduct;
    }

    /**
     * Собрать сущность Image
     *
     * @param string $fileName
     * @param string $path
     * @param string|null $description
     * @return Image
     */
    public static function createImage(
        string $fileName,
        string $path,
        ?string $description = null
    ): Image {
        $image = new Image();
        $image
            ->setFileName($fileName)
            ->setPath($path)
            ->setDescription($description)
        ;

        return $image;
    }

    /**
     * Собрать сущность Recipient
     *
     * @param string $firstName
     * @param string $email
     * @return Recipient
     */
    public static function createRecipient(string $firstName, string $email): Recipient
    {
        $recipient = new Recipient();
        $recipient
            ->setFirstName($firstName)
            ->setEmail($email)
        ;

        return $recipient;
    }

    /**
     * Собрать сущность HistoryOrderStatus
     *
     * @param OrderStatus $orderStatus
     * @return HistoryOrderStatus
     */
    public static function createHistoryOrderStatus(OrderStatus $orderStatus): HistoryOrderStatus
    {
        $historyOrderStatus = new HistoryOrderStatus();
        $historyOrderStatus->setStatus($orderStatus);

        return $historyOrderStatus;
    }

    /**
     * Собрать сущность Transaction
     *
     * @param Order $order
     * @param boolean $isActive
     * @return Transaction
     */
    public static function createTransaction(Order $order, bool $isActive = true): Transaction
    {
        $transaction = new Transaction();
        $transaction
            ->setOrder($order)
            ->setUuid(Uuid::v4())
            ->setSum($order->getTotalPrice())
            ->setIsActive($isActive)
        ;

        return $transaction;
    }

    /**
     * Собрать сущность Transaction
     *
     * @param PaymentType $paymentType
     * @param float $sum
     * @return Payment
     */
    public static function createPayment(PaymentType $paymentType, float $sum): Payment
    {
        $payment = new Payment();
        $payment
            ->setPaymentType($paymentType)
            ->setSum($sum)
        ;

        return $payment;
    }

    /**
     * Собрать сущность Transaction
     *
     * @param Payment $payment
     * @param CheckType $checkType
     * @param bool $isActive
     * @return PaymentCheck
     */
    public static function createPaymentCheck(
        Payment $payment,
        CheckType $checkType,
        bool $isActive = true
    ): PaymentCheck {
        $paymentCheck = new PaymentCheck();
        $paymentCheck
            ->setPayment($payment)
            ->setCheckType($checkType)
            ->setIsActive($isActive)
        ;

        return $paymentCheck;
    }

    /**
     * Собрать сущность OrderProduct
     *
     * @param Product $product
     * @param integer $quantity
     * @return OrderProduct
     */
    public static function createOrderProduct(Product $product, int $quantity): OrderProduct
    {
        $orderProduct = new OrderProduct();
        $orderProduct
            ->setProduct($product)
            ->setQuantity($quantity)
        ;

        return $orderProduct;
    }
}
