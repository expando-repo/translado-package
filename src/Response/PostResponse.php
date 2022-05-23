<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response;

use Expando\TransladoPackage\Exceptions\TransladoException;
use Expando\TransladoPackage\IResponse;

class PostResponse implements IResponse
{
    private string $hash;

    /**
     * PostResponse constructor.
     * @param array $data
     * @throws TransladoException
     */
    public function __construct(array $data)
    {
        if (($data['hash'] ?? null) === null) {
            throw new TransladoException('Response not return hash');
        }
        $this->hash = $data['hash'];
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}