<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Bash\Patterns\BashCommentPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashNumberPattern;
use Tempest\Highlight\Languages\Css\Patterns\CssCommentPattern;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsSinglelineCommentPattern;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformBlockTypePattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformBooleanPattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformHeredocPattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformInterpolationPattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformKeywordPattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformOperatorPattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformPropertyPattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformTypePattern;
use Tempest\Highlight\Languages\Terraform\Patterns\TerraformVariablePattern;

class TerraformLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'terraform';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['tf', 'hcl', 'terragrunt'];
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // COMMENTS
            new CssCommentPattern(),
            new BashCommentPattern(),
            new JsSinglelineCommentPattern(),

            // VALUES
            new TerraformHeredocPattern(),
            new DoubleQuoteValuePattern(),

            // BLOCK TYPES
            new TerraformBlockTypePattern(),

            // KEYWORDS
            new TerraformKeywordPattern(),

            // TYPES
            new TerraformTypePattern(),

            // BOOLEANS
            new TerraformBooleanPattern(),

            // VARIABLES
            new TerraformVariablePattern(),

            // INTERPOLATION
            new TerraformInterpolationPattern(),

            // PROPERTIES
            new TerraformPropertyPattern(),

            // OPERATORS
            new TerraformOperatorPattern(),

            // NUMBERS
            new BashNumberPattern(),
        ];
    }
}
