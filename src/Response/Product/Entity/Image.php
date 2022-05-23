<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Product\Entity;

class Image
{
    private int $image_id;
    private string $src;
    private ?int $position = null;
    private int $default;

    public function __construct(array $data)
    {
        $this->image_id = (int) $data['image_id'];
        $this->src = $data['src'];
        $this->position = (int) $data['position'] ?: null;
        $this->default = (int) $data['default'] ?: 0;
    }

    /**
     * @return int
     */
    public function getImageId(): int
    {
        return $this->image_id;
    }

    /**
     * @return string
     */
    public function getSrc(): string
    {
        return $this->src;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getDefault(): int
    {
        return $this->default;
    }
}