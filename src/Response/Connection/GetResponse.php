<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Connection;

use Expando\TransladoPackage\Exceptions\TransladoException;
use Expando\TransladoPackage\IResponse;

class GetResponse implements IResponse
{
    protected int $connection_id;
    protected string $title;
    protected string $icu;
    protected string $type;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TransladoException
     */
    public function __construct(array $data)
    {
        if (($data['connection_id'] ?? null) === null) {
            throw new TransladoException('Response product not return hash');
        }
        $this->connection_id = $data['connection_id'];
        $this->title = $data['title'];
        $this->icu = $data['icu'];
        $this->type = $data['type'];
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getIcu(): string
    {
        return $this->icu;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}