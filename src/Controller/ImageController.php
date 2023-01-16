<?php

namespace App\Controller;

use App\Component\Exception\ValidatorException;
use App\Component\Validator\ImageValidator;
use App\Dto\ControllerRequest\ImageRequest;
use App\Dto\ControllerRequest\ListRequest;
use App\Dto\ControllerResponse\ImageListResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Dto\Image as DtoImage;
use App\Service\ImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/image', name: 'api_image_')]
class ImageController extends AbstractController
{
    public function __construct(private readonly ImageService $imageService)
    {
    }

    /**
     * Список изображений
     *
     * @OA\Parameter(
     *      in="query",
     *      description="Сортировка (ASC, DESC)",
     *      name="orderBy"
     * ),
     * @OA\Parameter(
     *      in="query",
     *      description="Лимит",
     *      name="limit"
     * ),
     * @OA\Parameter(
     *      in="query",
     *      description="Смещение",
     *      name="offset"
     * ),
     * @OA\Response(
     *      response=200,
     *      description="Список изображений",
     *      @Model(type=ImageListResponse::class)
     * )
     * @OA\Tag(name="Image")
     * @param ListRequest $request
     * @return ImageListResponse
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(ListRequest $request): ImageListResponse
    {
        return $this->imageService->getImageList($request);
    }

    /**
     * Добавить изображение
     *
     * @OA\RequestBody(
     *      required=true,
     *      description="Файл изображения",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="image",
     *                  type="array",
     *                  @OA\Items(
     *                       type="string",
     *                       format="binary",
     *                  )
     *               ),
     *               @OA\Property(
     *                  property="description",
     *                  type="string"
     *               ),
     *           )
     *      )
     * )
     * @OA\Response(
     *      response=200,
     *      description="Информация о добавленном изображении",
     *      @Model(type=DtoImage::class)
     * )
     * @OA\Tag(name="Image")
     * @param Request $request
     * @return DtoImage
     * @throws ValidatorException
     */
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(Request $request): DtoImage
    {
        ImageValidator::validateImageRequest($request);

        return $this->imageService->addImage($request);
    }

    /**
     * Изменить информацию об изображении
     *
     * id — обязательный параметр
     *
     * @OA\RequestBody(
     *    description="Описание изображения",
     *    @Model(type=ImageRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Статус редактирования информации об изображении",
     *      @Model(type=SuccessResponse::class)
     * )
     * @OA\Tag(name="Image")
     * @param ImageRequest $request
     * @return SuccessResponse
     */
    #[Route('/edit', name: 'edit', methods: ['PUT'])]
    public function edit(ImageRequest $request): SuccessResponse
    {
        return $this->imageService->editImage($request);
    }

    /**
     * Удалить изображение
     *
     * id — обязательный параметр
     *
     * @OA\RequestBody(
     *    description="Данные об изображении (можно передать только id)",
     *    @Model(type=ImageRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Статус удаления изображения",
     *      @Model(type=SuccessResponse::class)
     * )
     * @OA\Tag(name="Image")
     * @param ImageRequest $request
     * @return SuccessResponse
     */
    #[Route('/delete', name: 'delete', methods: ['DELETE'])]
    public function delete(ImageRequest $request): SuccessResponse
    {
        return $this->imageService->deleteImage($request);
    }
}
