<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

class LinkField extends Field
{
    public function route(string $name, string $text, array $parameters = []): self
    {
        $this->set('route', route($name, $parameters));
        return $this->set('route_text', $text);
    }
}
