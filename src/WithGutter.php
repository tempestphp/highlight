<?php

namespace Tempest\Highlight;

use Tempest\Highlight\Renderers\GutterRenderer;

interface WithGutter
{
    public function setGutter(GutterRenderer $gutterRenderer): void;
}