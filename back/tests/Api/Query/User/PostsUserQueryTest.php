<?php

namespace App\Tests\Api\Query\User;

use App\Api\Query\User\PostsUserQuery;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class PostsUserQueryTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping(true)->getValidator();
    }

    public function testDataTransformation(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(42);

        $query = new PostsUserQuery($user, 50, 5);

        self::assertEquals(42, $query->getUser()->getId());
        self::assertEquals(50, $query->getLimit());
        self::assertEquals(4, $query->getPage());
    }

    /** @dataProvider validationDataProvider */
    public function testValidation(array $params, bool $violation): void
    {
        $query = new PostsUserQuery(...$params);
        $violationList = $this->validator->validate($query);

        if ($violation === false) {
            self::assertEmpty($violationList);
        } else {
            self::assertNotEmpty($violationList);
        }
    }

    public function validationDataProvider(): \Generator
    {
        yield 'valid 1' => [
            'params'    => [new User(), 1, 2],
            'violation' => false
        ];
    }
}
