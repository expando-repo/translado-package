<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Product;

use Expando\TransladoPackage\Exceptions\TransladoException;
use Expando\TransladoPackage\IResponse;
use Expando\TransladoPackage\Response\Product\Entity\Brand;
use Expando\TransladoPackage\Response\Product\Entity\Category;
use Expando\TransladoPackage\Response\Product\Entity\Image;
use Expando\TransladoPackage\Response\Product\Entity\Tag;
use Expando\TransladoPackage\Response\Product\Entity\Variant;

class GetResponse implements IResponse
{
    protected int $product_id;
    protected int $connection_id;
    protected ?int $change_id = null;
    protected string $status;
    protected ?string $message = null;
    protected array $data;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TransladoException
     */
    public function __construct(array $data)
    {
        if (($data['product_id'] ?? null) === null) {
            throw new TransladoException('Response product not return "product_id"');
        }

        $this->product_id = $data['product_id'];
        $this->connection_id = $data['connection_id'];
        $this->change_id = $data['change_id'];
        $this->status = $data['status'];
        $this->message = $data['message'];
        $this->data = $data['data'];
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return int
     */
    public function getConnectionId(): int
    {
        return $this->connection_id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int|null
     */
    public function getChangeId(): ?int
    {
        return $this->change_id;
    }

    /**
     * @return bool
     */
    public function hasProductData(): bool
    {
        return !empty($this->data);
    }

    /**
     * @return int|null
     */
    public function getIdentifier(): ?int
    {
        return $this->data['identifier'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getDescription2(): ?string
    {
        return $this->data['description2'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getDescriptionShort(): ?string
    {
        return $this->data['description_short'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->data['url'] ?? null;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        $result = [];
        foreach ($this->data['images'] ?? [] as $value) {
            if (($value['image_id'] ?? null)) {
                $result[] = new Image($value);
            }
        }
        return $result;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        $result = [];
        foreach ($this->data['tags'] ?? [] as $value) {
            if (($value['tag_id'] ?? null)) {
                $result[] = new Tag($value);
            }
        }
        return $result;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        $result = [];
        foreach ($this->data['categories'] ?? [] as $value) {
            if (($value['category_id'] ?? null)) {
                $result[] = new Category($value);
            }
        }
        return $result;
    }

    /**
     * @return Variant[]
     */
    public function getVariants(): array
    {
        $result = [];
        foreach ($this->data['variants'] ?? [] as $value) {
            if (($value['variant_id'] ?? null)) {
                $result[] = new Variant($value);
            }
        }
        return $result;
    }

    /**
     * @return Variant[]
     */
    public function getBrands(): array
    {
        $result = [];
        foreach ($this->data['brands'] ?? [] as $value) {
            if (($value['brand_id'] ?? null)) {
                $result[] = new Brand($value);
            }
        }
        return $result;
    }

    /**
     * @return Variant[]
     */
    public function getOptionsAsArray(): array
    {
        $result = [];
        foreach ($this->getVariants() as $variant) {
            foreach ($variant->getOptions() as $option) {
                if (!($result[$option->getOptionId()] ?? null)) {
                    $result[$option->getOptionId()] = [
                        'title' => $option->getName(),
                        'values' => [],
                    ];
                }

                $result[$option->getOptionId()]['values'][$option->getOptionValueId()] = [
                    'title' => $option->getValue(),
                ];
            }
        }
        return $result;
    }
}