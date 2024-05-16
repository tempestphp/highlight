<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers;

use Tempest\Highlight\Languages\Antlers\Patterns\AntlersTagParameter;
use Tempest\Highlight\Languages\Antlers\Patterns\KeywordPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\ModifierPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\NumberPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\OperatorPattern;
use Tempest\Highlight\Languages\Antlers\Patterns\VariablePattern;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\SingleQuoteValuePattern;
use Tempest\Highlight\Languages\Xml\Patterns\XmlAttributePattern;

class AntlersTagLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'antlerstag';
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

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

            new KeywordPattern('if'),
            new KeywordPattern('elseif'),
            new KeywordPattern('else'),
            new KeywordPattern('endif'),
            new KeywordPattern('unless'),

            new KeywordPattern('true'),
            new KeywordPattern('false'),


            new KeywordPattern('404'),
            new KeywordPattern('asset'),
            new KeywordPattern('assets'),
            new KeywordPattern('cache'),
            new KeywordPattern('children'),
            new KeywordPattern('collection'),
            new KeywordPattern('collection:count'),
            new KeywordPattern('collection:next'),
            new KeywordPattern('collection:previous'),
            new KeywordPattern('can'),
            new KeywordPattern('cookie'),
            new KeywordPattern('dd'),
            new KeywordPattern('ddd'),
            new KeywordPattern('dump'),
            new KeywordPattern('foreach'),
            new KeywordPattern('form'),
            new KeywordPattern('form:create'),
            new KeywordPattern('form:errors'),
            new KeywordPattern('form:set'),
            new KeywordPattern('form:submission'),
            new KeywordPattern('form:submissions'),
            new KeywordPattern('form:success'),
            new KeywordPattern('get_content'),
            new KeywordPattern('get_error'),
            new KeywordPattern('get_errors'),
            new KeywordPattern('get_files'),
            new KeywordPattern('glide'),
            new KeywordPattern('glide:batch'),
            new KeywordPattern('in'),
            new KeywordPattern('increment'),
            new KeywordPattern('installed'),
            new KeywordPattern('is'),
            new KeywordPattern('iterate'),
            new KeywordPattern('link'),
            new KeywordPattern('locales'),
            new KeywordPattern('locales:count'),
            new KeywordPattern('loop'),
            new KeywordPattern('markdown'),
            new KeywordPattern('markdown:indent'),
            new KeywordPattern('member'),
            new KeywordPattern('mix'),
            new KeywordPattern('mount_url'),
            new KeywordPattern('nav'),
            new KeywordPattern('nav:breadcrumbs'),
            new KeywordPattern('nocache'),
            new KeywordPattern('not_found'),
            new KeywordPattern('oauth'),
            new KeywordPattern('obfuscate'),
            new KeywordPattern('once'),
            new KeywordPattern('parent'),
            new KeywordPattern('partial'),
            new KeywordPattern('partial:exists'),
            new KeywordPattern('partial:if_exists'),
            new KeywordPattern('protect:password_form'),
            new KeywordPattern('path'),
            new KeywordPattern('push'),
            new KeywordPattern('query'),
            new KeywordPattern('range'),
            new KeywordPattern('redirect'),
            new KeywordPattern('route'),
            new KeywordPattern('relate'),
            new KeywordPattern('rotate'),
            new KeywordPattern('scope'),
            new KeywordPattern('section'),
            new KeywordPattern('session'),
            new KeywordPattern('session:dump'),
            new KeywordPattern('session:flash'),
            new KeywordPattern('session:flush'),
            new KeywordPattern('session:forget'),
            new KeywordPattern('session:has'),
            new KeywordPattern('session:set'),
            new KeywordPattern('set'),
            new KeywordPattern('structure'),
            new KeywordPattern('svg'),
            new KeywordPattern('switch'),
            new KeywordPattern('taxonomy'),
            new KeywordPattern('theme'),
            new KeywordPattern('trans'),
            new KeywordPattern('trans_choice'),
            new KeywordPattern('user_groups'),
            new KeywordPattern('user_roles'),
            new KeywordPattern('user:can'),
            new KeywordPattern('user:cant'),
            new KeywordPattern('user:forgot_password_form'),
            new KeywordPattern('user:in'),
            new KeywordPattern('user:is'),
            new KeywordPattern('user:login_form'),
            new KeywordPattern('user:logout'),
            new KeywordPattern('user:logout_url'),
            new KeywordPattern('user:profile'),
            new KeywordPattern('user:register_form'),
            new KeywordPattern('user:reset_password_form'),
            new KeywordPattern('users'),
            new KeywordPattern('vite'),
            new KeywordPattern('vite:content'),
            new KeywordPattern('yields'),
            new KeywordPattern('yield'),

            new XmlAttributePattern(),
            new NumberPattern(),
            new AntlersTagParameter(),
            new ModifierPattern(),
            new VariablePattern(),
        ];
    }
}
