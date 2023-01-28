<?php

namespace App\Service;

use App\Component\Builder\ProductBuilder;
use App\Component\Exception\BuilderException;
use App\Component\Exception\ProductException;
use App\Component\Factory\SimpleResponseFactory;
use App\Dto\ControllerRequest\ListRequest;
use App\Dto\ControllerRequest\ProductRequest;
use App\Dto\ControllerResponse\ProductListResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Dto\Image as DtoImage;
use App\Dto\Product;
use App\Entity\Image;
use App\Entity\Product as EntityProduct;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductService
{
    /**
     * @param ProductRepository $productRepository
     * @param ImageRepository $imageRepository
     * @param ProductBuilder $builder
     */
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ImageRepository $imageRepository,
        private readonly ProductBuilder $builder
    ) {
    }

    /**
     * Получить список товаров
     *
     * @param ListRequest $request
     * @return ProductListResponse
     */
    public function getProductList(ListRequest $request): ProductListResponse
    {
        $products = $this
            ->productRepository
            ->findBy(
                criteria: [],
                orderBy: ['id' => $request->orderBy],
                limit: $request->limit,
                offset: $request->offset
            );

        return SimpleResponseFactory::createProductListResponse($products);
    }

    /**
     * Добавить товар
     *
     * @param ProductRequest $request
     * @return Product
     * @throws BuilderException
     */
    public function addProduct(ProductRequest $request): Product
    {
        $product = $this
            ->builder
            ->setPrice($request->price)
            ->setTitle($request->title)
            ->setUrl($request->url)
            ->setDescription($request->description)
            ->setAuthor($request->author)
            ->setImage($this->getImages($request->image))
            ->build()
            ->getResult();

        $this->productRepository->save($product, true);

        return SimpleResponseFactory::createProduct($product);
    }

    /**
     * Изменить товар
     *
     * @param ProductRequest $request
     * @return Product
     * @throws ProductException
     * @throws BuilderException
     */
    public function editProduct(ProductRequest $request): Product
    {
        $product = $this->getProductById($request->id);

        $this
            ->builder
            ->setExistProduct($product)
            ->setPrice($request->price)
            ->setTitle($request->title)
            ->setUrl($request->url)
            ->setDescription($request->description)
            ->setAuthor($request->author)
            ->setImage($this->getImages($request->image))
            ->build()
            ->getResult();

        $this->productRepository->save($product, true);

        return SimpleResponseFactory::createProduct($product);
    }

    /**
     * Удалить товар
     *
     * @param ProductRequest $request
     * @return SuccessResponse
     * @throws ProductException
     */
    public function deleteProduct(ProductRequest $request): SuccessResponse
    {
        $product = $this->getProductById($request->id);
        $this->productRepository->remove($product, true);

        return SimpleResponseFactory::createSuccessResponse(true);
    }

    /**
     * Получить товар
     *
     * @param ProductRequest $request
     * @return Product
     * @throws ProductException
     */
    public function getProduct(ProductRequest $request): Product
    {
        $product = $this->getProductById($request->id);

        return SimpleResponseFactory::createProduct($product);
    }

    /**
     * Получить товар по идентификатору
     *
     * @param integer|null $id
     * @return EntityProduct
     * @throws ProductException
     */
    private function getProductById(?int $id): EntityProduct
    {
        if (null === $id) {
            throw new ProductException(
                message: 'Отсутствует обязательный параметр (id)',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'ID_NOT_FOUND',
                logLevel: LogLevel::WARNING
            );
        }

        $product = $this->productRepository->find($id);

        if (null === $product) {
            throw new ProductException(
                message: 'Отсутствуют товар с идентификатором ' . $id,
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'PRODUCT_NOT_FOUND',
                logLevel: LogLevel::WARNING
            );
        }

        return $product;
    }

    /**
     * Получить массив изображений
     *
     * @param DtoImage[] $images
     * @return Image[]
     */
    private function getImages(array $images): array
    {
        $ids = [];

        foreach ($images as $image) {
            $ids[] = $image->id;
        }

        return $this->imageRepository->getImagesByIds($ids);
    }
}
