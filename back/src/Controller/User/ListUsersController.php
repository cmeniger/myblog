<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Api\Factory\UserQueryCommandFactory;
use App\Api\Handler\User\SearchUserHandler;
use App\Model\ApiErrorModel;
use App\Model\ApiPaginatorModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use Exception;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListUsersController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     "/api/users",
     *     name="api_users"
     * )
     * @OA\Response(
     *     response=200,
     *     description="Show users list",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="_links",
     *             type="object",
     *             @OA\Property(property="self", type="string"),
     *             @OA\Property(property="first", type="string"),
     *             @OA\Property(property="last", type="string"),
     *             @OA\Property(property="next", type="string"),
     *             @OA\Property(property="prev", type="string"),
     *         ),
     *         @OA\Property(
     *             property="_embedded",
     *             type="object",
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(ref=@Model(type=User::class, groups={"list"}))
     *             )
     *         ),
     *         @OA\Property(property="page", type="number"),
     *         @OA\Property(property="pages", type="number"),
     *         @OA\Property(property="limit", type="number"),
     *         @OA\Property(property="total", type="number"),
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized"
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
     * @Security(name="Bearer")
     * @IsGranted("ROLE_ADMIN")
     */
    public function __invoke(
        Request $request,
        UserQueryCommandFactory $userQueryCommandFactory,
        SearchUserHandler $searchUserHandler
    ): Response
    {
        $context = new Context();
        $context->setGroups(['api', 'list']);

        $view = View::create();
        $view->setContext($context);

        try {
            $query = $userQueryCommandFactory->createSearchUserQuery(
                $request->query->get('limit'),
                $request->query->get('page')
            );
            $list = $searchUserHandler->handle($query);

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
