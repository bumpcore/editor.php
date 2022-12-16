<?php

namespace BumpCore\EditorPhp\Block;

use Illuminate\Support\Collection;

class BlockCollection extends Collection
{
    /**
     * Clears all items from the collection.
     *
     * @return $this
     */
    public function clear(): self
    {
        $this->items = [];

        return $this;
    }
}
