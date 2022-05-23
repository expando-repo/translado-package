<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Connection;

use Expando\TransladoPackage\Exceptions\TransladoException;
use Expando\TransladoPackage\IResponse;

class GetResponse implements IResponse
{
    protected int $connection_id;
    protected string $title;
    protected string $language;
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
        $this->language = $data['language'];
        $this->type = $data['type'];
    }

    /**
     * @return int|mixed
     */
    public function getConnectionId(): mixed
    {
        return $this->connection_id;
    }

    /**
     * @return mixed|string
     */
    public function getTitle(): mixed
    {
        return $this->title;
    }

    /**
     * @return mixed|string
     */
    public function getLanguage(): mixed
    {
        return $this->language;
    }

    /**
     * @return mixed|string
     */
    public function getType(): mixed
    {
        return $this->type;
    }
}