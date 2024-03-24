<?php
/**
 * Created by PhpStorm.
 * User: Jozef Môstka
 * Date: 24. 3. 2024
 * Time: 6:56
 */
namespace Tempest\Highlight\Languages\Twig\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

class TwigKeywordInjection implements Injection{

	use IsInjection;

	public function getPattern(): string
	{
		return '(?<match>({%(.|\n)*?%}))';
	}

	public function parseContent(string $content, Highlighter $highlighter): string
	{
		return $highlighter->parse($content, 'twig');
	}
}