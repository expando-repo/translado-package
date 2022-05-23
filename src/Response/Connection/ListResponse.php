<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Connection;

use Expando\TransladoPackage\Exceptions\TransladoException;
use Expando\TransladoPackage\IResponse;

class ListResponse implements IResponse
{
    /** @var GetResponse[]  */
    private array $connections = [];
    private string $status;

    /**
     * ListResponse constructor.
     * @param array $data
     * @throws TransladoException()
     */
    public function __construct(array $data)
    {
        if (($data['connections'] ?? null) === null) {
            throw new TransladoException('Response is empty');
        }
        $this->status = $data['status'];
        foreach ($data['connections'] as $item) {
            $this->connections[$item['connection_id']] = new GetResponse($item);
        }
    }

    /**
     * @return GetResponse[]
     */
    public function getConnections(): array
    {
        return $this->connections;
    }

    /**
     * @return mixed|string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}