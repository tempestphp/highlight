<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers;

use Tempest\Highlight\Languages\Antlers\Patterns\CommentInTagPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\LiteralPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\ModifierPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\NumberPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\OperatorPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\TagPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\VariablePattern;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\SingleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\VariablePattern as PhpVariablePattern;
use Tempest\Highlight\Languages\Xml\Patterns\XmlAttributePattern;

class AntlersDelimitedLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'antlersdelimited';
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            new CommentInTagPattern(),

            // VALUES
            new SingleQuoteValuePattern(),
            new DoubleQuoteValuePattern(),

            new OperatorPattern('>'),
            new OperatorPattern('<'),
            new OperatorPattern('<='),
            new OperatorPattern('>='),
            new OperatorPattern('==='),
            new OperatorPattern('!=='),
            new OperatorPattern('=='),
            new OperatorPattern('!='),
            new OperatorPattern('+'),
            new OperatorPattern('-'),
            new OperatorPattern('+='),
            new OperatorPattern('-='),
            new OperatorPattern('&&'),
            new OperatorPattern('and'),
            new OperatorPattern('||'),
            new OperatorPattern('or'),
            new OperatorPattern('xor'),
            new OperatorPattern('<=>'),
            new OperatorPattern('?'),
            new OperatorPattern('?='),
            new OperatorPattern('??'),

            new TagPattern('if'),
            new TagPattern('elseif'),
            new TagPattern('else'),
            new TagPattern('endif'),
            new TagPattern('unless'),

            new LiteralPattern('true'),
            new LiteralPattern('false'),
            new LiteralPattern('null'),

            // Statamic core tags: https://statamic.dev/tags
            new TagPattern('404'),
            new TagPattern('asset'),
            new TagPattern('assets'),
            new TagPattern('cache'),
            new TagPattern('children'),
            new TagPattern('collection'),
            new TagPattern('collection:count'),
            new TagPattern('collection:next'),
            new TagPattern('collection:previous'),
            new TagPattern('can'),
            new TagPattern('cookie'),
            new TagPattern('dd'),
            new TagPattern('ddd'),
            new TagPattern('dump'),
            new TagPattern('foreach'),
            new TagPattern('form'),
            new TagPattern('form:create'),
            new TagPattern('form:errors'),
            new TagPattern('form:set'),
            new TagPattern('form:submission'),
            new TagPattern('form:submissions'),
            new TagPattern('form:success'),
            new TagPattern('get_content'),
            new TagPattern('get_error'),
            new TagPattern('get_errors'),
            new TagPattern('get_files'),
            new TagPattern('glide'),
            new TagPattern('glide:batch'),
            new TagPattern('in'),
            new TagPattern('increment'),
            new TagPattern('installed'),
            new TagPattern('is'),
            new TagPattern('iterate'),
            new TagPattern('link'),
            new TagPattern('locales'),
            new TagPattern('locales:count'),
            new TagPattern('loop'),
            new TagPattern('markdown'),
            new TagPattern('markdown:indent'),
            new TagPattern('member'),
            new TagPattern('mix'),
            new TagPattern('mount_url'),
            new TagPattern('nav'),
            new TagPattern('nav:breadcrumbs'),
            new TagPattern('nocache'),
            new TagPattern('not_found'),
            new TagPattern('oauth'),
            new TagPattern('obfuscate'),
            new TagPattern('once'),
            new TagPattern('parent'),
            new TagPattern('partial'),
            new TagPattern('partial:exists'),
            new TagPattern('partial:if_exists'),
            new TagPattern('protect:password_form'),
            new TagPattern('path'),
            new TagPattern('push'),
            new TagPattern('query'),
            new TagPattern('range'),
            new TagPattern('redirect'),
            new TagPattern('route'),
            new TagPattern('relate'),
            new TagPattern('rotate'),
            new TagPattern('scope'),
            new TagPattern('section'),
            new TagPattern('session'),
            new TagPattern('session:dump'),
            new TagPattern('session:flash'),
            new TagPattern('session:flush'),
            new TagPattern('session:forget'),
            new TagPattern('session:has'),
            new TagPattern('session:set'),
            new TagPattern('set'),
            new TagPattern('structure'),
            new TagPattern('svg'),
            new TagPattern('switch'),
            new TagPattern('taxonomy'),
            new TagPattern('theme'),
            new TagPattern('trans'),
            new TagPattern('trans_choice'),
            new TagPattern('user_groups'),
            new TagPattern('user_roles'),
            new TagPattern('user:can'),
            new TagPattern('user:cant'),
            new TagPattern('user:forgot_password_form'),
            new TagPattern('user:in'),
            new TagPattern('user:is'),
            new TagPattern('user:login_form'),
            new TagPattern('user:logout'),
            new TagPattern('user:logout_url'),
            new TagPattern('user:profile'),
            new TagPattern('user:register_form'),
            new TagPattern('user:reset_password_form'),
            new TagPattern('users'),
            new TagPattern('vite'),
            new TagPattern('vite:content'),
            new TagPattern('yields'),
            new TagPattern('yield'),

            new XmlAttributePattern(),
            new NumberPattern(),
            new ModifierPattern(),
            new PhpVariablePattern(),
            new VariablePattern(),
        ];
    }
}
