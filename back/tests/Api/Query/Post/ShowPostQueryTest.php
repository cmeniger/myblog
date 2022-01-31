<?php

namespace App\Tests\Api\Query\Post;

use App\Api\Query\Post\CommentsPostQuery;
use App\Api\Query\Post\ShowPostQuery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class ShowPostQueryTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping(true)->getValidator();
    }

    public function testDataTransformation(): void
    {
        $query = new ShowPostQuery(42);

        self::assertEquals(42, $query->getId());
    }

    /** @dataProvider validationDataProvider */
    public function testValidation(array $params, bool $violation): void
    {
        $query = new ShowPostQuery(...$params);
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
            'params'    => [1],
            'violation' => false
        ];
    }
}
