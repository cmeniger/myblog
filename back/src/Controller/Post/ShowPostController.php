<?php

namespace App\Controller\Post;

use App\Api\Factory\PostQueryCommandFactory;
use App\Api\Handler\Post\ShowPostHandler;
use App\Entity\Post;
use App\Model\ApiErrorModel;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowPostController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     "/api/post/{id}",
     *     name="api_post_show",
     *     requirements={"id"="\d+"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Show post",
     *     @Model(type=Post::class, groups={"show"}),
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not found",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\Tag(name="Post")
     */
    public function __invoke(
        Request $request,
        int $id,
        PostQueryCommandFactory $postQueryCommandFactory,
        ShowPostHandler $showPostHandler
    ): Response
    {
        $context = new Context();
        $context->setGroups(['api', 'show']);

        $view = View::create();
        $view->setContext($context);

        try {
            $query = $postQueryCommandFactory->createShowPostQuery($id);
            $post = $showPostHandler->handle($query);

            $view->setStatusCode(Response::HTTP_OK);
            $view->setData($post);
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
