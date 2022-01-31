<?php

namespace App\Tests\Api\Query\User;

use App\Api\Query\User\SearchUserQuery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class SearchUserQueryTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping(true)->getValidator();
    }

    public function testDataTransformation(): void
    {
        $query = new SearchUserQuery(50, 10);

        self::assertEquals(50, $query->getLimit());
        self::assertEquals(9, $query->getPage());
    }

    /** @dataProvider validationDataProvider */
    public function testValidation(array $params, bool $violation): void
    {
        $query = new SearchUserQuery(...$params);
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
