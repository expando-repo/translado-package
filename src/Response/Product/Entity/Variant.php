<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Product\Entity;

class Variant
{
    private int $variant_id;
    private ?string $identifier = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $description2 = null;
    private ?string $description_short = null;
    private ?float $price = null;
    private ?float $vat = null;
    private ?string $ean = null;
    private ?string $sku = null;
    private int $stock = 0;
    private ?string $image_url = null;
    private array $options = [];

    public function __construct(array $data)
    {
        $this->variant_id = (int) $data['variant_id'];
        $this->identifier = $data['identifier'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->description2 = $data['description2'] ?? null;
        $this->description_short = $data['description_short'] ?? null;
        $this->price = (float) $data['price'] ?: null;
        $this->vat = (float) $data['vat'] ?: null;
        $this->ean = $data['ean'] ?? null;
        $this->sku = $data['sku'] ?? null;
        $this->stock = (int) $data['stock'] ?? 0;
        $this->image_url = $data['image_url'] ?? null;
        foreach ($data['options'] ?? [] as $value) {
            if (($value['option_id'] ?? null) && ($value['option_value_id'] ?? null)) {
                $this->options[] = new Option($value);
            }
        }
    }

    /**
     * @return int
     */
    public function getVariantId(): int
    {
        return $this->variant_id;
    }

    /**
     * @return mixed|string|null
     */
    public function getIdentifier(): mixed
    {
        return $this->identifier;
    }

    /**
     * @return mixed|string|null
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

    /**
     * @return mixed|string|null
     */
    public function getDescription2(): mixed
    {
        return $this->description2;
    }

    /**
     * @return mixed|string|null
     */
    public function getDescriptionShort(): mixed
    {
        return $this->description_short;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return float|null
     */
    public function getVat(): ?float
    {
        return $this->vat;
    }

    /**
     * @return mixed|string|null
     */
    public function getEan(): mixed
    {
        return $this->ean;
    }

    /**
     * @return mixed|string|null
     */
    public function getSku(): mixed
    {
        return $this->sku;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @return mixed|string|null
     */
    public function getImageUrl(): mixed
    {
        return $this->image_url;
    }

    /**
     * @return Option[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}