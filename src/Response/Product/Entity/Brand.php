<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Product\Entity;

class Brand
{
    private int $brand_id;
    private string $title;

    public function __construct(array $data)
    {
        $this->brand_id = (int) $data['brand_id'];
        $this->title = $data['title'];
    }

    /**
     * @return int
     */
    public function getTagId(): int
    {
        return $this->tag_id;
    }

    /**
     * @return mixed|string
     */
    public function getTitle(): mixed
    {
        return $this->title;
    }
}