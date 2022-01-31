<?php

namespace App\Tests\Model;

use App\Model\ApiPaginatorModel;
use PHPUnit\Framework\TestCase;

class ApiPaginatorModelTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $model = new ApiPaginatorModel([]);

        self::assertEquals(ApiPaginatorModel::DEFAULT_PAGE, $model->page);
        self::assertEquals(ApiPaginatorModel::DEFAULT_LIMIT, $model->limit);
        self::assertEquals(null, $model->total);
        self::assertNull($model->pages);
        self::assertCount(2, $model->_links);
        self::assertArrayHasKey('self', $model->_links);
        self::assertArrayHasKey('first', $model->_links);
        self::assertArrayHasKey('items', $model->_embedded);
        self::assertCount(0, $model->_embedded['items']);
    }

    public function testCustomValues(): void
    {
        $model = new ApiPaginatorModel(['test', 'test'], 10, 20, 202);

        self::assertEquals(10, $model->page);
        self::assertEquals(20, $model->limit);
        self::assertEquals(202, $model->total);
        self::assertEquals(11, $model->pages);
        self::assertCount(5, $model->_links);
        self::assertArrayHasKey('self', $model->_links);
        self::assertArrayHasKey('first', $model->_links);
        self::assertArrayHasKey('prev', $model->_links);
        self::assertArrayHasKey('last', $model->_links);
        self::assertArrayHasKey('next', $model->_links);
        self::assertArrayHasKey('items', $model->_embedded);
        self::assertCount(2, $model->_embedded['items']);
    }
}
