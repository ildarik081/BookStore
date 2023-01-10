<?php

namespace App\Controller;

use App\Dto\ControllerRequest\BaseRequest;
use App\Dto\ControllerResponse\BaseResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/search', name: 'api_search_')]
class SearchController extends AbstractController
{
    /**
     * Поиск по названию
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Search")
     * @param BaseRequest $request
     * @return BaseResponse
     */
    #[Route(name: 'title', methods: ['POST'])]
    public function searchByTitle(BaseRequest $request): BaseResponse
    {
        return new BaseResponse();
    }
}
