<?php

namespace App\Component\Factory;

use App\Component\Interface\ProductInterface;
use App\Component\Utils\Aliases;
use App\Dto\ControllerResponse\AcquiringResponse;
use App\Dto\ControllerResponse\ImageListResponse;
use App\Dto\ControllerResponse\OrderListResponse;
use App\Dto\ControllerResponse\ProductListResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Dto\FullOrder;
use App\Dto\HistoryOrderStatus as DtoHistoryOrderStatus;
use App\Dto\Image as DtoImage;
use App\Dto\OrderProduct;
use App\Dto\Product as DtoProduct;
use App\Entity\HistoryOrderStatus;
use App\Entity\Product;
use App\Entity\Image;
use App\Entity\Order;
use Doctrine\Common\Collections\Collection;

class SimpleResponseFactory
{
    /**
     * @param boolean $success
     * @return SuccessResponse
     */
    public static function createSuccessResponse(bool $success): SuccessResponse
    {
        $response = new SuccessResponse();
        $response->success = $success;

        return $response;
    }

    /**
     * @param Product[] $products
     * @return ProductListResponse
     */
    public static function createProductListResponse(array $products): ProductListResponse
    {
        $response = new ProductListResponse();
        $response->products = self::createProducts($products);

        return $response;
    }

    /**
     * @param Product $product
     * @return DtoProduct
     */
    public static function createProduct(Product $product): DtoProduct
    {
        $productDto = new DtoProduct();
        $productDto->id = $product->getId();
        $productDto->price = $product->getPrice();
        $productDto->title = $product->getTitle();
        $productDto->description = $product->getDescription();
        $productDto->author = $product->getAuthor();
        $productDto->images = self::createImagesFromCollection($product->getImages());

        return $productDto;
    }

    /**
     * @param Collection<int, Image> $images
     * @return DtoImage[]
     */
    public static function createImagesFromCollection(Collection $images): array
    {
        $result = [];

        foreach ($images as $image) {
            $result[] = self::createImage($image);
        }

        return $result;
    }

    /**
     * @param Image[] $images
     * @return ImageListResponse
     */
    public static function createImageListResponse(array $images): ImageListResponse
    {
        $response = new ImageListResponse();
        $response->images = self::createImages($images);

        return $response;
    }

    /**
     * @param Image $image
     * @return DtoImage
     */
    public static function createImage(Image $image): DtoImage
    {
        $imageDto = new DtoImage();
        $imageDto->id = $image->getId();
        $imageDto->fileName = $image->getFileName();
        $imageDto->path = $image->getPath();
        $imageDto->description = $image->getDescription();

        return $imageDto;
    }

    /**
     * @param string $paymentLink
     * @return AcquiringResponse
     */
    public static function createAcquiringResponse(string $paymentLink): AcquiringResponse
    {
        $response = new AcquiringResponse();
        $response->paymentLink = $paymentLink;

        return $response;
    }

    /**
     * @param Order[] $orders
     * @return OrderListResponse
     */
    public static function createOrderListResponse(array $orders): OrderListResponse
    {
        $response = new OrderListResponse();
        $response->list = self::createFullOrders($orders);

        return $response;
    }

    /**
     * @param Order[] $orders
     * @return FullOrder[]
     */
    private static function createFullOrders(array $orders): array
    {
        $result = [];

        foreach ($orders as $order) {
            $fullOrder = new FullOrder();
            $fullOrder->dtCreate = ($order->getDtCreate())->format(Aliases::DT_FORMAT);
            $fullOrder->totalPrice = $order->getTotalPrice();
            $fullOrder->history = self::createHistoryOrderStatuses($order->getHistoryOrderStatus());
            $fullOrder->products = self::createOrderProducts($order->getOrderProduct());

            $result[] = $fullOrder;
            unset($fullOrder);
        }

        return $result;
    }

    /**
     * @param Collection<int, HistoryOrderStatus> $histories
     * @return array
     */
    private static function createHistoryOrderStatuses(Collection $histories): array
    {
        $result = [];

        foreach ($histories as $history) {
            $historyOrderStatus = new DtoHistoryOrderStatus();
            $historyOrderStatus->dtCreate = ($history->getDtCreate())->format(Aliases::DT_FORMAT);
            $historyOrderStatus->value = $history->getStatus()?->getValue();
            $historyOrderStatus->description = $history->getStatus()?->getDescription();

            $result[] = $historyOrderStatus;
            unset($historyOrderStatus);
        }

        return $result;
    }

    /**
     * @param Collection<int, ProductInterface> $products
     * @return array
     */
    private static function createOrderProducts(Collection $products): array
    {
        $result = [];

        foreach ($products as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->id = $product->getProduct()?->getId();
            $orderProduct->quantity = $product->getQuantity();
            $orderProduct->price = $product->getProduct()?->getPrice();
            $orderProduct->title = $product->getProduct()?->getTitle();
            $orderProduct->description = $product->getProduct()?->getDescription();
            $orderProduct->author = $product->getProduct()?->getAuthor();
            $orderProduct->images = self::createImages($product->getProduct()?->getImages());

            $result[] = $orderProduct;
            unset($orderProduct);
        }

        return $result;
    }

    /**
     * @param Image[]|Collection<int, Image> $images
     * @return DtoImage[]
     */
    private static function createImages(Collection|array $images): array
    {
        $result = [];

        /** @var Image $image */
        foreach ($images as $image) {
            $result[] = self::createImage($image);
        }

        return $result;
    }

    /**
     * @param Product[] $products
     * @return DtoProduct[]
     */
    private static function createProducts(array $products): array
    {
        $result = [];

        foreach ($products as $product) {
            $result[] = self::createProduct($product);
        }

        return $result;
    }
}
