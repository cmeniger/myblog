<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Model\ApiErrorModel;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;

class ProfileUserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     "/api/user/profile",
     *     name="api_user_profile"
     * )
     * @OA\Response(
     *     response=200,
     *     description="Show users list",
     *     @Model(type=User::class, groups={"detail"}),
     * )
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     * )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function __invoke(): Response
    {
        $context = new Context();
        $context->setGroups(['detail']);

        $view = View::create();
        $view->setContext($context);
        $view->setStatusCode(Response::HTTP_OK);
        $view->setData($this->getUser());

        return $this->handleView($view);
    }
}
