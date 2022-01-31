<?php

namespace App\Controller\User;

use App\Api\Factory\UserQueryCommandFactory;
use App\Api\Handler\User\PostsUserHandler;
use App\Entity\User;
use App\Model\ApiErrorModel;
use App\Model\ApiPaginatorModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use Exception;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class PostsUserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     "/api/user/posts",
     *     name="api_user_posts"
     * )
     * @OA\Response(
     *     response=200,
     *     description="Show posts list",
     *     @Model(type=ApiPaginatorModel::class, groups={"api", "list"}),
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
     * @OA\Tag(name="User")
     * @OA\Tag(name="Post")
     * @Security(name="Bearer")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function __invoke(
        Request $request,
        UserQueryCommandFactory $userQueryCommandFactory,
        PostsUserHandler $postsUserHandler
    ): Response
    {
        $context = new Context();
        $context->setGroups(['api', 'list']);

        $view = View::create();
        $view->setContext($context);

        try {
            /** @var ?User $user */
            $user = $this->getUser();
            if ($user === null) {
                throw new Exception('User not found');
            }

            $query = $userQueryCommandFactory->createPostsUserQuery(
                $user,
                $request->query->get('limit'),
                $request->query->get('page')
            );
            $list = $postsUserHandler->handle($query);

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
