<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Request;

use Expando\TransladoPackage\IRequest;

class VariantRequest extends Base implements IRequest
{
    private ?string $title = null;
    private ?string $identifier = null;
    private ?string $description = null;
    private ?string $description2 = null;
    private ?string $description_short = null;

    private ?float $price = null;
    private ?float $vat = null;

    private ?string $ean = null;
    private ?string $sku = null;
    private ?string $imageUrl = null;
    private ?int $stock = null;

    private array $options = [];

    /**
     * @param string $name
     * @param string $value
     * @param bool $isVariant
     */
    public function addOption(string $name, string $value, bool $isVariant = false): void
    {
        $option = [
            'name' => $name,
            'value' => $value,
            'variant' => $isVariant ? 1 : 0,
        ];
        $this->options[] = $option;
    }

    /**
     * @param string|null $identifier
     */
    public function setIdentifier(?string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @param string|null $ean
     */
    public function setEan(?string $ean): void
    {
        $this->ean = $ean;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string|null $description2
     */
    public function setDescription2(?string $description2): void
    {
        $this->description2 = $description2;
    }

    /**
     * @param string|null $description_short
     */
    public function setDescriptionShort(?string $description_short): void
    {
        $this->description_short = $description_short;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @param float|null $vat
     */
    public function setVat(?float $vat): void
    {
        $this->vat = $vat;
    }

    /**
     * @param string|null $sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @param string|null $imageUrl
     */
    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @param int|null $stock
     */
    public function setStock(?int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'identifier' => $this->identifier,
            'title' => $this->title,
            'description' => $this->description,
            'description2' => $this->description2,
            'description_short' => $this->description_short,
            'price' => $this->price,
            'vat' => $this->vat,
            'ean' => $this->ean,
            'sku' => $this->sku,
            'stock' => $this->stock,
            'image_url' => $this->imageUrl,
            'options' => $this->options,
        ];
    }
}