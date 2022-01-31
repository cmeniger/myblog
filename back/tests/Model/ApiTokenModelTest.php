<?php

namespace App\Tests\Model;

use App\Model\ApiTokenModel;
use PHPUnit\Framework\TestCase;

class ApiTokenModelTest extends TestCase
{
    public function testCustomValues(): void
    {
        $model = new ApiTokenModel('test');

        self::assertEquals('test', $model->token);
    }
}
