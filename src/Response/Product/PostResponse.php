<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Product;

use Expando\TransladoPackage\Exceptions\TransladoException;
use Expando\TransladoPackage\IResponse;

class PostResponse implements IResponse
{
    private int $product_id;

    /**
     * PostResponse constructor.
     * @param array $data
     * @throws TransladoException
     */
    public function __construct(array $data)
    {
        if (($data['product_id'] ?? null) === null) {
            throw new TransladoException('Response not return product_id');
        }
        $this->product_id = $data['product_id'];
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }
}