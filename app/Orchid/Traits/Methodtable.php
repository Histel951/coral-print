<?php

namespace App\Orchid\Traits;

trait Methodtable
{
    /**
     *
     * @param string $name
     * @param array $parameters
     * @return self
     */
    public function method(string $name, array $parameters = []): self
    {
        return $this->set('method', $name)->when(!empty($parameters), function () use ($parameters) {
            $this->set('parameters', $parameters);
        });
    }
}
