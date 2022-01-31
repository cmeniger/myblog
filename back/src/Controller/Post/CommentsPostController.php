<?php

namespace App\Controller\Post;

use App\Api\Factory\PostQueryCommandFactory;
use App\Api\Handler\Post\CommentsPostHandler;
use App\Model\ApiErrorModel;
use App\Model\ApiPaginatorModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use Exception;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentsPostController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     "/api/post/{id}/comments",
     *     name="api_post_comments",
     *     requirements={"id"="\d+"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Comments from post",
     *     @Model(type=ApiPaginatorModel::class, groups={"api", "list"}),
     * )
     * @OA\Response(
     *     response=404,
     *     description="Post not found",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
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
     * @OA\Tag(name="Comment")
     */
    public function __invoke(
        Request $request,
        int $id,
        PostQueryCommandFactory $postQueryCommandFactory,
        CommentsPostHandler $commentsPostHandler
    ): Response
    {
        $context = new Context();
        $context->setGroups(['api', 'list']);

        $view = View::create();
        $view->setContext($context);

        try {
            $query = $postQueryCommandFactory->createCommentsPostQuery(
                $id,
                $request->query->get('limit'),
                $request->query->get('page')
            );
            $list = $commentsPostHandler->handle($query);

            $view->setStatusCode(Response::HTTP_OK);
            $view->setData(
                new ApiPaginatorModel(
                    $list->getEntries(),
                    $list->getPage() + 1,
                    $list->getLimit(),
                    $list->getTotal()
                )
            );
        } catch (NotFoundHttpException $e) {
            $view->setStatusCode(Response::HTTP_NOT_FOUND);
            $view->setData(new ApiErrorModel($e->getMessage()));
        } catch (Exception $e) {
            $view->setStatusCode(Response::HTTP_BAD_REQUEST);
            $view->setData(new ApiErrorModel($e->getMessage()));
        }

        return $this->handleView($view);
    }
}
