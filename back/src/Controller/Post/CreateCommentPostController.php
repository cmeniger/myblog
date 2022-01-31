<?php

namespace App\Controller\Post;

use App\Api\Factory\PostQueryCommandFactory;
use App\Api\Handler\Post\CreateCommentPostHandler;
use App\Entity\User;
use App\Model\ApiErrorModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateCommentPostController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(
     *     "/api/post/{id}/comment",
     *     name="api_post_comment_create",
     *     requirements={"id"="\d+"}
     * )
     * @OA\Response(
     *     response=201,
     *     description="Create comment"
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
     * @OA\RequestBody(
     *     description="Post to create",
     *     required=true,
     *     @OA\JsonContent(
     *        type="array",
     *        example={
     *          "content": "Fusce pharetra convallis urna. Donec id justo. Quisque ut nisi."
     *        },
     *        @OA\Items(
     *            @OA\Property(
     *                property="content",
     *                type="string",
     *                example="Fusce pharetra convallis urna. Donec id justo. Quisque ut nisi."
     *            ),
     *        ),
     *     )
     * )
     * @OA\Tag(name="Post")
     * @OA\Tag(name="Comment")
     */
    public function __invoke(
        Request $request,
        int $id,
        PostQueryCommandFactory $postQueryCommandFactory,
        CreateCommentPostHandler $createCommentPostHandler
    ): Response
    {
        try {
            /** @var ?User $user */
            $user = $this->getUser();

            $payload = json_decode($request->getContent(), false);

            $command = $postQueryCommandFactory->createCreateCommentPostCommand(
                $id,
                $payload->content,
                $user
            );

            $createCommentPostHandler->handle($command);

            return $this->handleView(
                $this->view(null, Response::HTTP_CREATED)
            );
        } catch (NotFoundHttpException $e) {
            return $this->handleView(
                $this->view(new ApiErrorModel($e->getMessage()), Response::HTTP_NOT_FOUND)
            );
        } catch (Exception $e) {
            return $this->handleView(
                $this->view(new ApiErrorModel($e->getMessage()), Response::HTTP_BAD_REQUEST)
            );
        }
    }
}
