<?php

namespace App\Model;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

class ApiPaginatorModel
{
    public const DEFAULT_PAGE  = 1;
    public const DEFAULT_LIMIT = 20;

    /**
     * @var array
     * @Groups("api")
     * @OA\Property(
     *     type="object",
     *     @OA\Property(property="self", type="string"),
     *     @OA\Property(property="first", type="string"),
     *     @OA\Property(property="last", type="string"),
     *     @OA\Property(property="next", type="string"),
     *     @OA\Property(property="prev", type="string"),
     * ),
     */
    public $_links;

    /**
     * @var array
     * @Groups("api")
     * @OA\Property(
     *     type="object",
     *     @OA\Property(
     *         property="items",
     *         type="array",
     *         @OA\Items(type="object")
     *     )
     * ),
     */
    public $_embedded;

    /**
     * @var int
     * @Groups("api")
     */
    public $page;

    /**
     * @var int
     * @Groups("api")
     */
    public $limit;

    /**
     * @var int|null
     * @Groups("api")
     */
    public $total;

    /**
     * @var int|null
     * @Groups("api")
     */
    public $pages;

    public function __construct(
        array $items,
        int   $page = self::DEFAULT_PAGE,
        int   $limit = self::DEFAULT_LIMIT,
        ?int  $total = null
    )
    {
        $this->_embedded['items'] = $items;
        $this->page = $page;
        $this->limit = $limit;
        $this->total = $total;
        $this->pages = $total === null ? null : ceil($total / $limit);

        $this->addLinks();
    }

    private function addLinks(): void
    {
        $this->_links = [
            'self'  => sprintf('page=%s&limit=%s', $this->page, $this->limit),
            'first' => sprintf('page=%s&limit=%s', 1, $this->limit),
        ];

        if ($this->page > 1) {
            $this->_links['prev'] = sprintf('page=%s&limit=%s', $this->page - 1, $this->limit);
        }
        if ($this->pages !== null) {
            $this->_links['last'] = sprintf('page=%s&limit=%s', $this->pages, $this->limit);
            if ($this->page < $this->pages) {
                $this->_links['next'] = sprintf('page=%s&limit=%s', $this->page + 1, $this->limit);
            }
        }
    }
}
