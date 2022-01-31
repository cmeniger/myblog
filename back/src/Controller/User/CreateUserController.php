<?php

namespace App\Controller\User;

use App\Api\Factory\UserQueryCommandFactory;
use App\Api\Handler\User\CreateUserHandler;
use App\Model\ApiErrorModel;
use App\Model\ApiTokenModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(
     *     "/api/user",
     *     name="api_user_create"
     * )
     * @OA\Response(
     *     response=201,
     *     description="Create user",
     *     @Model(type=ApiTokenModel::class, groups={"api"}),
     * )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\RequestBody(
     *     description="User to create",
     *     required=true,
     *     @OA\JsonContent(
     *        type="array",
     *        example={
     *          "email": "john.do@domain.com",
     *          "password": "azerty"
     *        },
     *        @OA\Items(
     *            @OA\Property(
     *                property="email",
     *                type="string",
     *                example="john.do@domain.com"
     *            ),
     *            @OA\Property(
     *                property="password",
     *                type="string",
     *                example="azerty"
     *            ),
     *        ),
     *     )
     * )
     * @OA\Tag(name="User")
     */
    public function __invoke(
        Request $request,
        UserQueryCommandFactory $userQueryCommandFactory,
        CreateUserHandler $createUserHandler
    ): Response
    {
        try {
            $payload = json_decode($request->getContent(), false);

            $command = $userQueryCommandFactory->createCreateUserCommand(
                $payload->email,
                $payload->password
            );
            $token = $createUserHandler->handle($command);

            return $this->handleView(
                $this->view(new ApiTokenModel($token), Response::HTTP_CREATED)
            );
        } catch (Exception $e) {
            return $this->handleView(
                $this->view(new ApiErrorModel($e->getMessage()), Response::HTTP_BAD_REQUEST)
            );
        }
    }
}
