<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Product\Entity;

class Category
{
    private int $category_id;
    private string $title;
    private ?string $description = null;

    public function __construct(array $data)
    {
        $this->category_id = (int) $data['category_id'];
        $this->title = $data['title'];
        $this->description = $data['description'] ?? null;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @return mixed|string
     */
    public function getTitle(): mixed
    {
        return $this->title;
    }

    /**
     * @return mixed|string|null
     */
    public function getDescription(): mixed
    {
        return $this->description;
    }
}