<?php

namespace App\Services\Calculator\Config;

use Illuminate\Support\Traits\Macroable;

class CalculatorConfigBuilderService implements ConfigBuilder
{
    use Macroable;
    use ConfigClear;

    /**
     * Массив формирующихся конфигов
     * @var array
     */
    protected array $configs;

    /**
     * Ключ основного массива
     * @var string
     */
    protected string $generalKey = '';

    public function __construct(array $configs = [])
    {
        $this->configs = $configs;
    }

    public function setGeneralKey(string $key): static
    {
        $this->generalKey = $key;

        if (!isset($this->configs[$this->generalKey])) {
            $this->configs[$this->generalKey] = [];
        }

        return $this;
    }

    public function put(string $key, mixed $value): static
    {
        $this->configs[$this->generalKey][$key] = $value;

        return $this;
    }

    public function push(mixed $value): static
    {
        $this->configs[$this->generalKey] = [...$value];

        return $this;
    }

    public function getConfig(): array
    {
        return $this->cleanFields($this->configs);
    }
}
