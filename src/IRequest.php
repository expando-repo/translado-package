<?php

declare(strict_types=1);

namespace Expando\TransladoPackage;

interface IRequest
{
    public function asArray(): array;
}