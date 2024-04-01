<?php

namespace Tempest\Highlight;

interface Renderer
{
    public function render(string $content): string;
}