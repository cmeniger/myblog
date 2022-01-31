<?php

namespace App\Tests\Api\Query\Post;

use App\Api\Query\Post\SearchPostQuery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class SearchPostQueryTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping(true)->getValidator();
    }

    public function testDataTransformation(): void
    {
        $query = new SearchPostQuery(50, 10);

        self::assertEquals(50, $query->getLimit());
        self::assertEquals(9, $query->getPage());
    }

    /** @dataProvider validationDataProvider */
    public function testValidation(array $params, bool $violation): void
    {
        $query = new SearchPostQuery(...$params);
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
            'params'    => [1, 2],
            'violation' => false
        ];
    }
}
