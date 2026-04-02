<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Terraform;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class TerraformLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'terraform'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'tf'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'hcl'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
# Configure the AWS provider
provider "aws" {
  region = "us-east-1"
}

resource "aws_instance" "web" {
  ami           = var.ami_id
  instance_type = "t2.micro"
  count         = 3

  tags = {
    Name = "web-${var.environment}"
  }
}
TXT,
            <<<'TXT'
<span class="hl-comment"># Configure the AWS provider</span>
<span class="hl-keyword">provider</span> <span class="hl-value">&quot;aws&quot;</span> {
  <span class="hl-property">region</span> <span class="hl-operator">=</span> <span class="hl-value">&quot;us-east-1&quot;</span>
}

<span class="hl-keyword">resource</span> <span class="hl-value">&quot;aws_instance&quot;</span> <span class="hl-value">&quot;web&quot;</span> {
  <span class="hl-property">ami</span>           <span class="hl-operator">=</span> <span class="hl-variable">var.ami_id</span>
  <span class="hl-property">instance_type</span> <span class="hl-operator">=</span> <span class="hl-value">&quot;t2.micro&quot;</span>
  <span class="hl-keyword">count</span>         <span class="hl-operator">=</span> <span class="hl-number">3</span>

  <span class="hl-property">tags</span> <span class="hl-operator">=</span> {
    <span class="hl-property">Name</span> <span class="hl-operator">=</span> <span class="hl-value">&quot;web-${var.environment}&quot;</span>
  }
}
TXT],
            [<<<'TXT'
variable "instance_type" {
  type    = string
  default = "t2.micro"
}

output "instance_id" {
  value = module.server.id
}

// This is a single-line comment
/* This is a
   multi-line comment */
TXT,
            <<<'TXT'
<span class="hl-keyword">variable</span> <span class="hl-value">&quot;instance_type&quot;</span> {
  <span class="hl-property">type</span>    <span class="hl-operator">=</span> <span class="hl-type">string</span>
  <span class="hl-property">default</span> <span class="hl-operator">=</span> <span class="hl-value">&quot;t2.micro&quot;</span>
}

<span class="hl-keyword">output</span> <span class="hl-value">&quot;instance_id&quot;</span> {
  <span class="hl-property">value</span> <span class="hl-operator">=</span> <span class="hl-variable">module.server.id</span>
}

<span class="hl-comment">// This is a single-line comment</span>
<span class="hl-comment">/* This is a
   multi-line comment */</span>
TXT],
            [<<<'TXT'
resource "aws_iam_policy" "example" {
  policy = <<-POLICY
    {
      "Version": "2012-10-17",
      "Statement": []
    }
  POLICY
}
TXT,
            <<<'TXT'
<span class="hl-keyword">resource</span> <span class="hl-value">&quot;aws_iam_policy&quot;</span> <span class="hl-value">&quot;example&quot;</span> {
  <span class="hl-property">policy</span> <span class="hl-operator">=</span> <span class="hl-value">&lt;&lt;-POLICY
    {
      &quot;Version&quot;: &quot;2012-10-17&quot;,
      &quot;Statement&quot;: []
    }
  POLICY</span>
}
TXT],
        ];
    }
}
