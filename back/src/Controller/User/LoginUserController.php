<?php

namespace App\Controller\User;

use App\Model\ApiErrorModel;
use App\Model\ApiTokenModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;

class LoginUserController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(
     *     "/api/user/login",
     *     name="api_user_login"
     * )
     * @OA\Response(
     *     response=201,
     *     description="Login user",
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
    public function __invoke(): void
    {

    }
}
