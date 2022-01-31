<?php

namespace App\Controller\Post;

use App\Api\Factory\PostQueryCommandFactory;
use App\Api\Handler\Post\UpdatePostHandler;
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

class UpdatePostController extends AbstractFOSRestController
{
    /**
     * @Rest\Put(
     *     "/api/post/{id}",
     *     name="api_post_update",
     *     requirements={"id"="\d+"}
     * )
     * @OA\Response(
     *     response=201,
     *     description="Update post"
     * )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @Model(type=ApiErrorModel::class, groups={"api"}),
     * )
     * @OA\RequestBody(
     *     description="Update post",
     *     required=true,
     *     @OA\JsonContent(
     *        type="array",
     *        example={
     *          "title": "Mauris sollicitudin fermentum libero",
     *          "content": "Ut tincidunt tincidunt erat. Fusce pharetra convallis urna. Quisque ut nisi. Donec id justo."
     *        },
     *        @OA\Items(
     *            @OA\Property(
     *                property="title",
     *                type="string",
     *                example="Mauris sollicitudin fermentum libero"
     *            ),
     *            @OA\Property(
     *                property="content",
     *                type="string",
     *                example="Ut tincidunt tincidunt erat. Fusce pharetra convallis urna. Quisque ut nisi. Donec id justo."
     *            ),
     *        ),
     *     )
     * )
     * @OA\Tag(name="Post")
     * @Security(name="Bearer")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function __invoke(
        Request $request,
        int $id,
        PostQueryCommandFactory $postQueryCommandFactory,
        UpdatePostHandler $updatePostHandler
    ): Response
    {
        try {
            /** @var ?User $user */
            $user = $this->getUser();
            if ($user === null) {
                throw new Exception('User not found');
            }

            $payload = json_decode($request->getContent(), false);

            $command = $postQueryCommandFactory->createUpdatePostCommand(
                $id,
                $payload->title,
                $payload->content,
                $user
            );

            $updatePostHandler->handle($command);

            return $this->handleView(
                $this->view(null, Response::HTTP_OK)
            );
        } catch (Exception $e) {
            return $this->handleView(
                $this->view(new ApiErrorModel($e->getMessage()), Response::HTTP_BAD_REQUEST)
            );
        }
    }
}
