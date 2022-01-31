<?php

namespace App\Controller\Post;

use App\Api\Factory\PostQueryCommandFactory;
use App\Api\Handler\Post\DeletePostHandler;
use App\Entity\User;
use App\Model\ApiErrorModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DeletePostController extends AbstractFOSRestController
{
    /**
     * @Rest\Delete(
     *     "/api/post/{id}",
     *     name="api_post_delete",
     *     requirements={"id"="\d+"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="Post deleted"
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not found",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\Response(
     *     response=403,
     *     description="Not authorized",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\Tag(name="Post")
     * @Security(name="Bearer")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function __invoke(
        Request $request,
        int $id,
        PostQueryCommandFactory $postQueryCommandFactory,
        DeletePostHandler $deletePostHandler
    ): Response
    {
        try {
            /** @var ?User $user */
            $user = $this->getUser();
            if ($user === null) {
                throw new Exception('User not found');
            }

            $command = $postQueryCommandFactory->createDeletePostCommand(
                $id,
                $user
            );

            $deletePostHandler->handle($command);

            return $this->handleView(
                $this->view(null, Response::HTTP_OK)
            );
        } catch (NotFoundHttpException $e) {
            return $this->handleView(
                $this->view(new ApiErrorModel($e->getMessage()), Response::HTTP_NOT_FOUND)
            );
        } catch (UnauthorizedHttpException $e) {
            return $this->handleView(
                $this->view(new ApiErrorModel($e->getMessage()), Response::HTTP_FORBIDDEN)
            );
        } catch (Exception $e) {
            return $this->handleView(
                $this->view(new ApiErrorModel($e->getMessage()), Response::HTTP_BAD_REQUEST)
            );
        }
    }
}
