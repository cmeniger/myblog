<?php

namespace App\Tests\Model;

use App\Model\ApiErrorModel;
use PHPUnit\Framework\TestCase;

class ApiErrorModelTest extends TestCase
{
    public function testCustomValues(): void
    {
        $model = new ApiErrorModel('test');

        self::assertEquals('test', $model->error);
    }
}
