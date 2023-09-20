<?php

namespace App\Orchid\Layouts;

use Closure;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Repository;

class AsyncModalLayout extends Modal
{
    protected Closure $layoutsBuilder;

    /**
     * Modal constructor.
     *
     * @param string $key
     * @param array  $layouts
     */
    public function __construct(string $key, Closure $layoutsBuilder)
    {
        parent::__construct($key);

        $this->layoutsBuilder = $layoutsBuilder;
    }

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        $this->layouts = call_user_func($this->layoutsBuilder, $repository);

        return parent::build($repository);
    }

    public function getSlug(): string
    {
        return sha1($this->variables['key']);
    }
}
