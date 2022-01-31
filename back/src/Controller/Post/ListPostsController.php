<?php

namespace App\Controller\Post;

use App\Api\Factory\PostQueryCommandFactory;
use App\Api\Handler\Post\SearchPostHandler;
use App\Model\ApiErrorModel;
use App\Model\ApiPaginatorModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use Exception;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class ListPostsController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     "/api/posts",
     *     name="api_posts"
     * )
     * @OA\Response(
     *     response=200,
     *     description="Show posts list",
     *     @Model(type=ApiPaginatorModel::class, groups={"api"}),
     * )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page to show",
     *     @OA\Schema(type="int")
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Items to show per page",
     *     @OA\Schema(type="int")
     * )
     * @OA\Tag(name="Post")
     * @IsGranted("PUBLIC_ACCESS")
     */
    public function __invoke(
        Request $request,
        PostQueryCommandFactory $postQueryCommandFactory,
        SearchPostHandler $searchPostHandler
    ): Response
    {
        $context = new Context();
        $context->setGroups(['api', 'list']);

        $view = View::create();
        $view->setContext($context);

        try {
            $query = $postQueryCommandFactory->createSearchPostQuery(
                $request->query->get('limit'),
                $request->query->get('page')
            );
            $list = $searchPostHandler->handle($query);

            $view->setStatusCode(Response::HTTP_OK);
            $view->setData(
                new ApiPaginatorModel(
                    $list->getEntries(),
                    $list->getPage() + 1,
                    $list->getLimit(),
                    $list->getTotal()
                )
            );
        } catch (Exception $e) {
            $view->setStatusCode(Response::HTTP_BAD_REQUEST);
            $view->setData(new ApiErrorModel($e->getMessage()));
        }

        return $this->handleView($view);
    }
}
