<?php

namespace App\Tests\Api\Query\Post;

use App\Api\Query\Post\CommentsPostQuery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class CommentsPostQueryTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping(true)->getValidator();
    }

    public function testDataTransformation(): void
    {
        $query = new CommentsPostQuery(5, 10,4);

        self::assertEquals(5, $query->getId());
        self::assertEquals(10, $query->getLimit());
        self::assertEquals(3, $query->getPage());
    }

    /** @dataProvider validationDataProvider */
    public function testValidation(array $params, bool $violation): void
    {
        $query = new CommentsPostQuery(...$params);
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
            'params'    => [1, 2, 3],
            'violation' => false
        ];
    }
}
