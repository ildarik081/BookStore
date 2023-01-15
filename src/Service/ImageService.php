<?php

namespace App\Service;

use App\Component\Factory\EntityFactory;
use App\Component\Factory\SimpleResponseFactory;
use App\Component\Utils\Aliases;
use App\Dto\ControllerRequest\ImageRequest;
use App\Dto\ControllerRequest\ListRequest;
use App\Dto\ControllerResponse\ImageListResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Dto\Image;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    private const UPLOAD_PATH = '/uploads/';

    public function __construct(
        private readonly ImageRepository $imageRepository,
        private readonly string $workingDir
    ) {
    }

    /**
     * Получить список изображений
     *
     * @param ListRequest $request
     * @return ImageListResponse
     */
    public function getImageList(ListRequest $request): ImageListResponse
    {
        $images = $this
            ->imageRepository
            ->findBy(
                criteria: [],
                orderBy: ['id' => $request->orderBy],
                limit: $request->limit,
                offset: $request->offset
            );

        return SimpleResponseFactory::createImageListResponse($images);
    }

    /**
     * Добавить изображение
     *
     * @param Request $request
     * @return Image
     */
    public function addImage(Request $request): Image
    {
        /** @var UploadedFile $file */
        $file = $request->files->get(Aliases::UPLOAD_PROPERTY_NAME_IMAGE);

        /** @var string $description */
        $description = $request->request->get('description');
        $path = $this->workingDir . '/public' . self::UPLOAD_PATH;

        $fileName = uniqid() . '—' . $file->getClientOriginalName();
        $file->move($path, $fileName);
        $image = EntityFactory::createImage($fileName, self::UPLOAD_PATH, $description);

        $this->imageRepository->save($image, true);

        return SimpleResponseFactory::createImage($image);
    }

    /**
     * Изменить информацию об изображении
     *
     * @param ImageRequest $request
     * @return SuccessResponse
     */
    public function editImage(ImageRequest $request): SuccessResponse
    {
        $image = $this
            ->imageRepository
            ->getImageById($request->id)
            ->setDescription($request->description);

        $this->imageRepository->save($image, true);

        return SimpleResponseFactory::createSuccessResponse(true);
    }

    /**
     * Удалить изображение
     *
     * @param ImageRequest $request
     * @return SuccessResponse
     */
    public function deleteImage(ImageRequest $request): SuccessResponse
    {
        $image = $this
            ->imageRepository
            ->getImageById($request->id);

        $this->imageRepository->remove($image, true);

        return SimpleResponseFactory::createSuccessResponse(true);
    }
}
