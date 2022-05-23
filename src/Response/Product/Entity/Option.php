<?php

declare(strict_types=1);

namespace Expando\TransladoPackage\Response\Product\Entity;

class Option
{
    private int $option_id;
    private int $option_value_id;
    private string $name;
    private string $value;
    private int $variant;

    public function __construct(array $data)
    {
        $this->option_id = (int) $data['option_id'];
        $this->option_value_id = (int) $data['option_value_id'];
        $this->name = $data['name'];
        $this->value = $data['value'];
        $this->variant = (int) $data['variant'];
    }

    /**
     * @return int
     */
    public function getOptionId(): int
    {
        return $this->option_id;
    }

    /**
     * @return int
     */
    public function getOptionValueId(): int
    {
        return $this->option_value_id;
    }

    /**
     * @return mixed|string
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @return mixed|string
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getVariant(): int
    {
        return $this->variant;
    }
}