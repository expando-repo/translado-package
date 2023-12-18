<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Request;

use Expando\TransladoPackage\IRequest;

class ProductRequest extends Base implements IRequest
{
    private int $connectionId;
    private ?int $productId = null;
    private string $status = 'active';
    private string $identifier;

    private string $title;
    private ?string $description = null;
    private ?string $description2 = null;
    private ?string $description_short = null;

    private ?string $url = null;
    private array $tags = [];
    private array $categories = [];
    private array $images = [];
    private array $variants = [];
    private array $brands = [];

    public function __construct(int $connectionId, ?int $productId = null)
    {
        $this->connectionId = $connectionId;
        $this->productId = $productId;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getConnectionId(): int
    {
        return $this->connectionId;
    }

    /**
     * @param VariantRequest $variantRequest
     * @return void
     */
    public function addVariant(VariantRequest $variantRequest): void
    {
        $this->variants[] = $variantRequest->asArray();
    }


    /**
     * @param string $url
     * @param int|null $position
     * @param false $default
     * @return void
     */
    public function addImageUrl(string $url, ?int $position = null, bool $default = false): void
    {
        $image = [
            'position' => $position,
            'src' => $url,
            'default' => (int) $default,
        ];
        $this->images[] = $image;
    }

    /**
     * @param string $title
     * @return void
     */
    public function addBrand(string $title): void
    {
        $brand = [
            'title' => $title,
        ];
        $this->brands[] = $brand;
    }

    /**
     * @param string $title
     * @param string|null $description
     * @return void
     */
    public function addCategory(string $title, ?string $description = null): void
    {
        $category = [
            'title' => $title,
            'description' => $description,
        ];
        $this->categories[] = $category;
    }

    /**
     * @param string $title
     * @return void
     */
    public function addTag(string $title): void
    {
        $tag = [
            'title' => $title,
        ];
        $this->tags[] = $tag;
    }

    /**
     * @return void
     */
    public function active(): void
    {
        $this->status = 'active';
    }

    /**
     * @return void
     */
    public function inactive(): void
    {
        $this->status = 'inactive';
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
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
     * @return array
     */
    public function asArray(): array
    {
        return [
            'connection_id' => $this->connectionId,
            'product_id' => $this->productId,
            'status' => $this->status,
            'identifier' => $this->identifier,
            'title' => $this->title,
            'description' => $this->description,
            'description2' => $this->description2,
            'description_short' => $this->description_short,
            'url' => $this->url,
            'brands' => $this->brands,
            'images' => $this->images,
            'tags' => $this->tags,
            'categories' => $this->categories,
            'variants' => $this->variants,
        ];
    }
}
