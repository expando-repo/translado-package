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
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    /**
     * @return string|null
     */
    public function getDescriptionShort(): ?string
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
     * @return string|null
     */
    public function getEan(): ?string
    {
        return $this->ean;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
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
     * @return string|null
     */
    public function getImageUrl(): ?string
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