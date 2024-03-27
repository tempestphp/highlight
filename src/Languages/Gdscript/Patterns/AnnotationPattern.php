<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Gdscript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class AnnotationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        $variations = join('|@export_', [
            'category',
            'color_no_alpha',
            'dir',
            'enum',
            'exp_easing',
            'file',
            'flags',
            'flags_2d_navigation',
            'flags_2d_physics',
            'flags_2d_render',
            'flags_3d_navigation',
            'flags_3d_physics',
            'flags_3d_render',
            'flags_avoidance',
            'global_dir',
            'global_file',
            'group',
            'multiline',
            'node_path',
            'placeholder',
            'range',
            'subgroup',
        ]);

        return "(?<match>(@onready|@icon|@export|@export_{$variations}|@rpc|@static_unload|@tool|@warning_ignore))";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
