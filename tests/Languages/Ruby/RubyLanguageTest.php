<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Ruby;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class RubyLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'ruby'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'rb'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
# A simple user model
class User < ApplicationRecord
  attr_reader :name, :email

  def initialize(name, email: nil)
    @name = name
    @email = email
  end
end
TXT,
            <<<'TXT'
<span class="hl-comment"># A simple user model</span>
<span class="hl-keyword">class</span> <span class="hl-type">User</span> <span class="hl-operator">&lt;</span> <span class="hl-type">ApplicationRecord</span>
  <span class="hl-keyword">attr_reader</span> <span class="hl-literal">:name</span>, <span class="hl-literal">:email</span>

  <span class="hl-keyword">def</span> <span class="hl-property">initialize</span>(name, <span class="hl-property">email</span>: <span class="hl-literal">nil</span>)
    <span class="hl-variable">@name</span> <span class="hl-operator">=</span> name
    <span class="hl-variable">@email</span> <span class="hl-operator">=</span> email
  <span class="hl-keyword">end</span>
<span class="hl-keyword">end</span>
TXT],
            [<<<'TXT'
=begin
Multiline comment
=end
def admin?
  return false unless defined?(@roles)

  @roles.include?(:admin) || options[:force] == true
end
TXT,
            <<<'TXT'
<span class="hl-comment">=begin
Multiline comment
=end</span>
<span class="hl-keyword">def</span> <span class="hl-property">admin?</span>
  <span class="hl-keyword">return</span> <span class="hl-literal">false</span> <span class="hl-keyword">unless</span> <span class="hl-keyword">defined?</span>(<span class="hl-variable">@roles</span>)

  <span class="hl-variable">@roles</span>.include?(<span class="hl-literal">:admin</span>) <span class="hl-operator">||</span> options[<span class="hl-literal">:force</span>] <span class="hl-operator">==</span> <span class="hl-literal">true</span>
<span class="hl-keyword">end</span>
TXT],
            [<<<'TXT'
names = %w[alice bob]
total = 1_000 + 0x1F * 2.5e3
message = "Hello, #{names.first}!"
sql = <<~SQL
  SELECT * FROM users
SQL
TXT,
            <<<'TXT'
names <span class="hl-operator">=</span> <span class="hl-value">%w[alice bob]</span>
total <span class="hl-operator">=</span> <span class="hl-number">1_000</span> <span class="hl-operator">+</span> <span class="hl-number">0x1F</span> <span class="hl-operator">*</span> <span class="hl-number">2.5e3</span>
message <span class="hl-operator">=</span> <span class="hl-value">&quot;Hello, #{names.first}!&quot;</span>
sql <span class="hl-operator">=</span> <span class="hl-value">&lt;&lt;~SQL</span>
<span class="hl-value">  SELECT * FROM users
SQL</span>
TXT],
            [<<<'TXT'
text = "hello
# still a string
false"
x = "abc\\"; y = "def"
name = "#{user["name"]}!"
# don't break 'strings'
z = 'a'
TXT,
            <<<'TXT'
text <span class="hl-operator">=</span> <span class="hl-value">&quot;hello
# still a string
false&quot;</span>
x <span class="hl-operator">=</span> <span class="hl-value">&quot;abc\\&quot;</span>; y <span class="hl-operator">=</span> <span class="hl-value">&quot;def&quot;</span>
name <span class="hl-operator">=</span> <span class="hl-value">&quot;#{user[&quot;name&quot;]}!&quot;</span>
<span class="hl-comment"># don't break 'strings'</span>
z <span class="hl-operator">=</span> <span class="hl-value">'a'</span>
TXT],
            [<<<'TXT'
puts(<<~MSG, :ok) # comment
  Don't panic
MSG
puts(<<A, <<B)
first
A
second
B
TXT,
            <<<'TXT'
puts(<span class="hl-value">&lt;&lt;~MSG</span>, <span class="hl-literal">:ok</span>) <span class="hl-comment"># comment</span>
<span class="hl-value">  Don't panic
MSG</span>
puts(<span class="hl-value">&lt;&lt;A</span>, <span class="hl-value">&lt;&lt;B</span>)
<span class="hl-value">first
A</span>
<span class="hl-value">second
B</span>
TXT],
            [<<<'TXT'
text = <<~text
false
text
quoted = <<'foo-bar'
x
foo-bar
plain = <<EOS
  EOS
false
EOS
TXT,
            <<<'TXT'
text <span class="hl-operator">=</span> <span class="hl-value">&lt;&lt;~text</span>
<span class="hl-value">false
text</span>
quoted <span class="hl-operator">=</span> <span class="hl-value">&lt;&lt;'foo-bar'</span>
<span class="hl-value">x
foo-bar</span>
plain <span class="hl-operator">=</span> <span class="hl-value">&lt;&lt;EOS</span>
<span class="hl-value">  EOS
false
EOS</span>
TXT],
            [<<<'TXT'
bits = 1
flags = bits <<MASK
puts :one
MASK
TXT,
            <<<'TXT'
bits <span class="hl-operator">=</span> <span class="hl-number">1</span>
flags <span class="hl-operator">=</span> bits <span class="hl-operator">&lt;&lt;</span><span class="hl-type">MASK</span>
puts <span class="hl-literal">:one</span>
<span class="hl-type">MASK</span>
TXT],
            [<<<'TXT'
a = %q{outer {inner} false}
b = %q{a\} false}
q = [2]; x = 10 %q[0]
%i[a b]
TXT,
            <<<'TXT'
a <span class="hl-operator">=</span> <span class="hl-value">%q{outer {inner} false}</span>
b <span class="hl-operator">=</span> <span class="hl-value">%q{a\} false}</span>
q <span class="hl-operator">=</span> [<span class="hl-number">2</span>]; x <span class="hl-operator">=</span> <span class="hl-number">10</span> <span class="hl-operator">%</span>q[<span class="hl-number">0</span>]
<span class="hl-value">%i[a b]</span>
TXT],
            [<<<'TXT'
=begin
false
=end?
true
=end
false
TXT,
            <<<'TXT'
<span class="hl-comment">=begin
false
=end?
true
=end</span>
<span class="hl-literal">false</span>
TXT],
            [<<<'TXT'
options = {class: User, private: true}
def require(path); end
def User.foo; end
def obj.bar; end
TXT,
            <<<'TXT'
options <span class="hl-operator">=</span> {<span class="hl-property">class</span>: <span class="hl-type">User</span>, <span class="hl-property">private</span>: <span class="hl-literal">true</span>}
<span class="hl-keyword">def</span> <span class="hl-property">require</span>(path); <span class="hl-keyword">end</span>
<span class="hl-keyword">def</span> <span class="hl-type">User</span>.<span class="hl-property">foo</span>; <span class="hl-keyword">end</span>
<span class="hl-keyword">def</span> obj.<span class="hl-property">bar</span>; <span class="hl-keyword">end</span>
TXT],
            [<<<'TXT'
a ? b: c
a & b | c ^ d; !enabled; ~mask; save!
TXT,
            <<<'TXT'
a <span class="hl-operator">?</span> b: c
a <span class="hl-operator">&amp;</span> b <span class="hl-operator">|</span> c <span class="hl-operator">^</span> d; <span class="hl-operator">!</span>enabled; <span class="hl-operator">~</span>mask; save!
TXT],
            [<<<'TXT'
:name=; :==; :[]; { :id=>1 }
1e1_0; 0d10; 1r; 1i
TXT,
            <<<'TXT'
<span class="hl-literal">:name=</span>; <span class="hl-literal">:==</span>; <span class="hl-literal">:[]</span>; { <span class="hl-literal">:id</span><span class="hl-operator">=&gt;</span><span class="hl-number">1</span> }
<span class="hl-number">1e1_0</span>; <span class="hl-number">0d10</span>; <span class="hl-number">1r</span>; <span class="hl-number">1i</span>
TXT],
            [<<<'TXT'
text = <<TEXT
=begin
TEXT
command = `cat <<EOS`
puts 'done'
EOS
TXT,
            <<<'TXT'
text <span class="hl-operator">=</span> <span class="hl-value">&lt;&lt;TEXT</span>
<span class="hl-value">=begin
TEXT</span>
command <span class="hl-operator">=</span> <span class="hl-value">`cat &lt;&lt;EOS`</span>
puts <span class="hl-value">'done'</span>
<span class="hl-type">EOS</span>
TXT],
            [<<<'TXT'
def f(q, bits); bits %q[0]; end
def g(bits)
  bits <<MASK
MASK
end
TXT,
            <<<'TXT'
<span class="hl-keyword">def</span> <span class="hl-property">f</span>(q, bits); bits <span class="hl-operator">%</span>q[<span class="hl-number">0</span>]; <span class="hl-keyword">end</span>
<span class="hl-keyword">def</span> <span class="hl-property">g</span>(bits)
  bits <span class="hl-operator">&lt;&lt;</span><span class="hl-type">MASK</span>
<span class="hl-type">MASK</span>
<span class="hl-keyword">end</span>
TXT],
            [<<<'TXT'
# puts = 1
puts <<MSG
hello
MSG
puts = 1
obj.puts <<MSG
hi
MSG
TXT,
            <<<'TXT'
<span class="hl-comment"># puts = 1</span>
puts <span class="hl-value">&lt;&lt;MSG</span>
<span class="hl-value">hello
MSG</span>
puts <span class="hl-operator">=</span> <span class="hl-number">1</span>
obj.puts <span class="hl-value">&lt;&lt;MSG</span>
<span class="hl-value">hi
MSG</span>
TXT],
            [<<<'TXT'
q = {'a' => 3}
x = 10 %q['a']
key = :"#{user["name"]}"
x = ok ?  foo: bar
TXT,
            <<<'TXT'
q <span class="hl-operator">=</span> {<span class="hl-value">'a'</span> <span class="hl-operator">=&gt;</span> <span class="hl-number">3</span>}
x <span class="hl-operator">=</span> <span class="hl-number">10</span> <span class="hl-operator">%</span>q[<span class="hl-value">'a'</span>]
key <span class="hl-operator">=</span> <span class="hl-literal">:&quot;#{user[&quot;name&quot;]}&quot;</span>
x <span class="hl-operator">=</span> ok <span class="hl-operator">?</span>  foo: bar
TXT],
            [<<<'TXT'
email.match?(/"/) && name =~ /a b/i
x = a / b / c
TXT,
            <<<'TXT'
email.match?(<span class="hl-value">/&quot;/</span>) <span class="hl-operator">&amp;&amp;</span> name <span class="hl-operator">=~</span> <span class="hl-value">/a b/i</span>
x <span class="hl-operator">=</span> a <span class="hl-operator">/</span> b <span class="hl-operator">/</span> c
TXT],
            [<<<'TXT'
pattern = /#{Regexp.escape("a/b")}/
text = %Q|#{items.join("|")}|
path = base.public_send(:/, "app/models")
def /(other); "#{self}/#{other}"; end
TXT,
            <<<'TXT'
pattern <span class="hl-operator">=</span> <span class="hl-value">/#{Regexp.escape(&quot;a/b&quot;)}/</span>
text <span class="hl-operator">=</span> <span class="hl-value">%Q|#{items.join(&quot;|&quot;)}|</span>
path <span class="hl-operator">=</span> base.public_send(<span class="hl-literal">:/</span>, <span class="hl-value">&quot;app/models&quot;</span>)
<span class="hl-keyword">def</span> <span class="hl-property">/</span>(other); <span class="hl-value">&quot;#{self}/#{other}&quot;</span>; <span class="hl-keyword">end</span>
TXT],
            [<<<'TXT'
pattern = /hello
# world
"there"/x
puts "done"
TXT,
            <<<'TXT'
pattern <span class="hl-operator">=</span> <span class="hl-value">/hello
# world
&quot;there&quot;/x</span>
puts <span class="hl-value">&quot;done&quot;</span>
TXT],
            [<<<'TXT'
total = 120
average = total /(count = items.size)/2
result = count /2 / 3
def scale total, count
  total /count / 2
end
scale = ->(total, count) { total /count / 2 }
def scale(total = Integer(ENV.fetch("TOTAL")), count)
  count /2 / 3
end
result = total \
  /2 / 5
TXT,
            <<<'TXT'
total <span class="hl-operator">=</span> <span class="hl-number">120</span>
average <span class="hl-operator">=</span> total <span class="hl-operator">/</span>(count <span class="hl-operator">=</span> items.size)<span class="hl-operator">/</span><span class="hl-number">2</span>
result <span class="hl-operator">=</span> count <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">3</span>
<span class="hl-keyword">def</span> <span class="hl-property">scale</span> total, count
  total <span class="hl-operator">/</span>count <span class="hl-operator">/</span> <span class="hl-number">2</span>
<span class="hl-keyword">end</span>
scale <span class="hl-operator">=</span> <span class="hl-operator">-&gt;</span>(total, count) { total <span class="hl-operator">/</span>count <span class="hl-operator">/</span> <span class="hl-number">2</span> }
<span class="hl-keyword">def</span> <span class="hl-property">scale</span>(total <span class="hl-operator">=</span> <span class="hl-type">Integer</span>(<span class="hl-type">ENV</span>.fetch(<span class="hl-value">&quot;TOTAL&quot;</span>)), count)
  count <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">3</span>
<span class="hl-keyword">end</span>
result <span class="hl-operator">=</span> total \
  <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>
TXT],
            [<<<'TXT'
user.allowed? role: :admin
valid? class: User
TXT,
            <<<'TXT'
user.allowed? <span class="hl-property">role</span>: <span class="hl-literal">:admin</span>
valid? <span class="hl-property">class</span>: <span class="hl-type">User</span>
TXT],
            [<<<'TXT'
def scale(count, pattern = /x/); count /2 / 5; end
f = ->(count, pattern = /x/) { count /2 / 5 }
def ratio = (total = 120; total /2 / 5)
def emit(options = {log: false, puts: true})
  puts <<~MSG
    hello
  MSG
end
TXT,
            <<<'TXT'
<span class="hl-keyword">def</span> <span class="hl-property">scale</span>(count, pattern <span class="hl-operator">=</span> <span class="hl-value">/x/</span>); count <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>; <span class="hl-keyword">end</span>
f <span class="hl-operator">=</span> <span class="hl-operator">-&gt;</span>(count, pattern <span class="hl-operator">=</span> <span class="hl-value">/x/</span>) { count <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span> }
<span class="hl-keyword">def</span> <span class="hl-property">ratio</span> <span class="hl-operator">=</span> (total <span class="hl-operator">=</span> <span class="hl-number">120</span>; total <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>)
<span class="hl-keyword">def</span> <span class="hl-property">emit</span>(options <span class="hl-operator">=</span> {<span class="hl-property">log</span>: <span class="hl-literal">false</span>, <span class="hl-property">puts</span>: <span class="hl-literal">true</span>})
  puts <span class="hl-value">&lt;&lt;~MSG</span>
<span class="hl-value">    hello
  MSG</span>
<span class="hl-keyword">end</span>
TXT],
            [<<<'TXT'
css = %Q{body { color: #{color}; }}
json = %q{{"data": {"id": 1}}}
text = %!Hello #{name}!
pattern = %r{hello}im
TXT,
            <<<'TXT'
css <span class="hl-operator">=</span> <span class="hl-value">%Q{body { color: #{color}; }}</span>
json <span class="hl-operator">=</span> <span class="hl-value">%q{{&quot;data&quot;: {&quot;id&quot;: 1}}}</span>
text <span class="hl-operator">=</span> <span class="hl-value">%!Hello #{name}!</span>
pattern <span class="hl-operator">=</span> <span class="hl-value">%r{hello}im</span>
TXT],
            [<<<'TXT'
pattern = valid? ? /yes/ :/no/
words = ready? ? [] :%w[hello world]
handler = method(:<<)
return / \A [a-z]+ \z /x
TXT,
            <<<'TXT'
pattern <span class="hl-operator">=</span> valid? <span class="hl-operator">?</span> <span class="hl-value">/yes/</span> <span class="hl-operator">:</span><span class="hl-value">/no/</span>
words <span class="hl-operator">=</span> ready? <span class="hl-operator">?</span> [] <span class="hl-operator">:</span><span class="hl-value">%w[hello world]</span>
handler <span class="hl-operator">=</span> method(<span class="hl-literal">:&lt;&lt;</span>)
<span class="hl-keyword">return</span> <span class="hl-value">/ \A [a-z]+ \z /x</span>
TXT],
            [<<<'TXT'
operator = divide? ? :/ : :*
text = %q\hello\
pattern = %r=\A/users/\d+\z=i
x %= 3
sql = <<~'SQL QUERY'
  SELECT true
SQL QUERY
puts 2 / 3
TXT,
            <<<'TXT'
operator <span class="hl-operator">=</span> divide? <span class="hl-operator">?</span> <span class="hl-literal">:/</span> <span class="hl-operator">:</span> <span class="hl-literal">:*</span>
text <span class="hl-operator">=</span> <span class="hl-value">%q\hello\</span>
pattern <span class="hl-operator">=</span> <span class="hl-value">%r=\A/users/\d+\z=i</span>
x <span class="hl-operator">%=</span> <span class="hl-number">3</span>
sql <span class="hl-operator">=</span> <span class="hl-value">&lt;&lt;~'SQL QUERY'</span>
<span class="hl-value">  SELECT true
SQL QUERY</span>
puts <span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">3</span>
TXT],
            [<<<'TXT'
operation = divide? ? method(:/) : method(:*)
list = ok ? [:/] : (:*)
pattern = /safe/
TXT,
            <<<'TXT'
operation <span class="hl-operator">=</span> divide? <span class="hl-operator">?</span> method(<span class="hl-literal">:/</span>) <span class="hl-operator">:</span> method(<span class="hl-literal">:*</span>)
list <span class="hl-operator">=</span> ok <span class="hl-operator">?</span> [<span class="hl-literal">:/</span>] <span class="hl-operator">:</span> (<span class="hl-literal">:*</span>)
pattern <span class="hl-operator">=</span> <span class="hl-value">/safe/</span>
TXT],
            [<<<'TXT'
pattern = ready? ? %r|yes| :/no/
(count, total) = [2, 120]
count /2 / 5
case payload
in {count:} | [count, *]
  count /2 / 5
in {status: "ok"}
  status /2/
end
payload => {total:}
total /2 / 5
TXT,
            <<<'TXT'
pattern <span class="hl-operator">=</span> ready? <span class="hl-operator">?</span> <span class="hl-value">%r|yes|</span> <span class="hl-operator">:</span><span class="hl-value">/no/</span>
(count, total) <span class="hl-operator">=</span> [<span class="hl-number">2</span>, <span class="hl-number">120</span>]
count <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>
<span class="hl-keyword">case</span> payload
<span class="hl-keyword">in</span> {<span class="hl-property">count</span>:} <span class="hl-operator">|</span> [count, <span class="hl-operator">*</span>]
  count <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>
<span class="hl-keyword">in</span> {<span class="hl-property">status</span>: <span class="hl-value">&quot;ok&quot;</span>}
  status <span class="hl-value">/2/</span>
<span class="hl-keyword">end</span>
payload <span class="hl-operator">=&gt;</span> {<span class="hl-property">total</span>:}
total <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>
TXT],
            [<<<'TXT'
case payload
in {status: /ok/, count:}
  count /2 / 5
  status /2/
end
payload => {
  total:
}
total /2 / 5
if payload in {size:}
  size /2 / 5
end
(payload => {length:})
length /2 / 5
/(?<template>.+)/ =~ input
puts(template %{name: 'Alice'})
TXT,
            <<<'TXT'
<span class="hl-keyword">case</span> payload
<span class="hl-keyword">in</span> {<span class="hl-property">status</span>: <span class="hl-value">/ok/</span>, <span class="hl-property">count</span>:}
  count <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>
  status <span class="hl-value">/2/</span>
<span class="hl-keyword">end</span>
payload <span class="hl-operator">=&gt;</span> {
  <span class="hl-property">total</span>:
}
total <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>
<span class="hl-keyword">if</span> payload <span class="hl-keyword">in</span> {<span class="hl-property">size</span>:}
  size <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>
<span class="hl-keyword">end</span>
(payload <span class="hl-operator">=&gt;</span> {<span class="hl-property">length</span>:})
length <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span> <span class="hl-number">5</span>
<span class="hl-value">/(?&lt;template&gt;.+)/</span> <span class="hl-operator">=~</span> input
puts(template <span class="hl-operator">%</span>{<span class="hl-property">name</span>: <span class="hl-value">'Alice'</span>})
TXT],
            [<<<'TXT'
handlers = {
  :word => handler
}
handler /word/
@in = input
input /word/
if /user=(\d+)/ =~ line
  puts $1, $~, $!
end
puts DATA.read
__END__
Hello, # data
TXT,
            <<<'TXT'
handlers <span class="hl-operator">=</span> {
  <span class="hl-literal">:word</span> <span class="hl-operator">=&gt;</span> handler
}
handler <span class="hl-value">/word/</span>
<span class="hl-variable">@in</span> <span class="hl-operator">=</span> input
input <span class="hl-value">/word/</span>
<span class="hl-keyword">if</span> <span class="hl-value">/user=(\d+)/</span> <span class="hl-operator">=~</span> line
  puts <span class="hl-variable">$1</span>, <span class="hl-variable">$~</span>, <span class="hl-variable">$!</span>
<span class="hl-keyword">end</span>
puts <span class="hl-type">DATA</span>.read
<span class="hl-comment">__END__
Hello, # data</span>
TXT],
            [
                "def render_page(count)\n  render(inline: '" . str_repeat('<p>Hi</p>', 60) . "<div class=\"x\"></div>', locals: {pattern: /ok/})\n  count /2 /5\nend",
                '<span class="hl-keyword">def</span> <span class="hl-property">render_page</span>(count)' . "\n"
                . '  render(<span class="hl-property">inline</span>: <span class="hl-value">\'' . str_repeat('&lt;p&gt;Hi&lt;/p&gt;', 60) . '&lt;div class=&quot;x&quot;&gt;&lt;/div&gt;\'</span>, <span class="hl-property">locals</span>: {<span class="hl-property">pattern</span>: <span class="hl-value">/ok/</span>})' . "\n"
                . '  count <span class="hl-operator">/</span><span class="hl-number">2</span> <span class="hl-operator">/</span><span class="hl-number">5</span>' . "\n"
                . '<span class="hl-keyword">end</span>',
            ],
            [<<<'TXT'
puts "#{text.gsub(/"/, '')}"
puts "done"
x = "a #{h["k"] + "#{b ? "y" : "z"}"} b"
y = "#{a / b} and #{c / d}"
value = instance_variable_get(:@name) || :@@count || :$stdout
TXT,
            <<<'TXT'
puts <span class="hl-value">&quot;#{text.gsub(/&quot;/, '')}&quot;</span>
puts <span class="hl-value">&quot;done&quot;</span>
x <span class="hl-operator">=</span> <span class="hl-value">&quot;a #{h[&quot;k&quot;] + &quot;#{b ? &quot;y&quot; : &quot;z&quot;}&quot;} b&quot;</span>
y <span class="hl-operator">=</span> <span class="hl-value">&quot;#{a / b} and #{c / d}&quot;</span>
value <span class="hl-operator">=</span> instance_variable_get(<span class="hl-literal">:@name</span>) <span class="hl-operator">||</span> <span class="hl-literal">:@@count</span> <span class="hl-operator">||</span> <span class="hl-literal">:$stdout</span>
TXT],
            [<<<'TXT'
a = "#{items.join(%q("))}"
b = "#{text.gsub /"/, "'"}"
c = /[#{Regexp.escape("[")}]/
d = "#{
  user.name # May contain a " character
}"
e = "#{x / y} #{x % y} #{x %w[z].size}"
puts "done"
TXT,
            <<<'TXT'
a <span class="hl-operator">=</span> <span class="hl-value">&quot;#{items.join(%q(&quot;))}&quot;</span>
b <span class="hl-operator">=</span> <span class="hl-value">&quot;#{text.gsub /&quot;/, &quot;'&quot;}&quot;</span>
c <span class="hl-operator">=</span> <span class="hl-value">/[#{Regexp.escape(&quot;[&quot;)}]/</span>
d <span class="hl-operator">=</span> <span class="hl-value">&quot;#{
  user.name # May contain a &quot; character
}&quot;</span>
e <span class="hl-operator">=</span> <span class="hl-value">&quot;#{x / y} #{x % y} #{x %w[z].size}&quot;</span>
puts <span class="hl-value">&quot;done&quot;</span>
TXT],
            [<<<'TXT'
a = "#{prefix + %q(")}"
b = "#{header << %q(")}"
c = "Sanitized: #{text.delete(?#, ?").strip}"
d = "Remaining: #{$'.delete("\n")}"
e = "#{if / "/.match?(text); "yes"; else; "no"; end}"
puts "done"
TXT,
            <<<'TXT'
a <span class="hl-operator">=</span> <span class="hl-value">&quot;#{prefix + %q(&quot;)}&quot;</span>
b <span class="hl-operator">=</span> <span class="hl-value">&quot;#{header &lt;&lt; %q(&quot;)}&quot;</span>
c <span class="hl-operator">=</span> <span class="hl-value">&quot;Sanitized: #{text.delete(?#, ?&quot;).strip}&quot;</span>
d <span class="hl-operator">=</span> <span class="hl-value">&quot;Remaining: #{$'.delete(&quot;\n&quot;)}&quot;</span>
e <span class="hl-operator">=</span> <span class="hl-value">&quot;#{if / &quot;/.match?(text); &quot;yes&quot;; else; &quot;no&quot;; end}&quot;</span>
puts <span class="hl-value">&quot;done&quot;</span>
TXT],
            [<<<'TXT'
half = sizes.next / 2
invoice.total /= 2
pattern = /=foo/
fallback = Regexp.new(input) rescue / (?!) /x
label = "#{sizes.next / 2} #{invoice.total /= 2}"
puts "/done"
TXT,
            <<<'TXT'
half <span class="hl-operator">=</span> sizes.next <span class="hl-operator">/</span> <span class="hl-number">2</span>
invoice.total <span class="hl-operator">/=</span> <span class="hl-number">2</span>
pattern <span class="hl-operator">=</span> <span class="hl-value">/=foo/</span>
fallback <span class="hl-operator">=</span> <span class="hl-type">Regexp</span>.new(input) <span class="hl-keyword">rescue</span> <span class="hl-value">/ (?!) /x</span>
label <span class="hl-operator">=</span> <span class="hl-value">&quot;#{sizes.next / 2} #{invoice.total /= 2}&quot;</span>
puts <span class="hl-value">&quot;/done&quot;</span>
TXT],
            [<<<'TXT'
invoice.total /=2
average = records.count \
  / 2
alias original_run `
message = "#{format(<<~TEXT)}"
  This is "quoted" text.
TEXT
joined = <<~MSG
  one \
  MSG
  two
MSG
/(?'template'.+)/ =~ input
puts(template %{name: 'Alice'})
def average((total, count), d = foo(e))
  total /count / 2
  e /2/
end
TXT,
            <<<'TXT'
invoice.total <span class="hl-operator">/=</span><span class="hl-number">2</span>
average <span class="hl-operator">=</span> records.count \
  <span class="hl-operator">/</span> <span class="hl-number">2</span>
<span class="hl-keyword">alias</span> original_run `
message <span class="hl-operator">=</span> <span class="hl-value">&quot;#{format(&lt;&lt;~TEXT)}&quot;</span>
<span class="hl-value">  This is &quot;quoted&quot; text.
TEXT</span>
joined <span class="hl-operator">=</span> <span class="hl-value">&lt;&lt;~MSG</span>
<span class="hl-value">  one \
  MSG
  two
MSG</span>
<span class="hl-value">/(?'template'.+)/</span> <span class="hl-operator">=~</span> input
puts(template <span class="hl-operator">%</span>{<span class="hl-property">name</span>: <span class="hl-value">'Alice'</span>})
<span class="hl-keyword">def</span> <span class="hl-property">average</span>((total, count), d <span class="hl-operator">=</span> foo(e))
  total <span class="hl-operator">/</span>count <span class="hl-operator">/</span> <span class="hl-number">2</span>
  e <span class="hl-value">/2/</span>
<span class="hl-keyword">end</span>
TXT],
            [<<<'TXT'
case line
when /="[^"]*"/
  puts :yes
end
label = "#{line if /=x/}"
puts "done"
TXT,
            <<<'TXT'
<span class="hl-keyword">case</span> line
<span class="hl-keyword">when</span> <span class="hl-value">/=&quot;[^&quot;]*&quot;/</span>
  puts <span class="hl-literal">:yes</span>
<span class="hl-keyword">end</span>
label <span class="hl-operator">=</span> <span class="hl-value">&quot;#{line if /=x/}&quot;</span>
puts <span class="hl-value">&quot;done&quot;</span>
TXT],
            [<<<'TXT'
# Example:
#   def
attr_accessor :name
headers = { "Content-Type": "json" }
TXT,
            <<<'TXT'
<span class="hl-comment"># Example:</span>
<span class="hl-comment">#   def</span>
<span class="hl-keyword">attr_accessor</span> <span class="hl-literal">:name</span>
headers <span class="hl-operator">=</span> { <span class="hl-value">&quot;Content-Type&quot;</span>: <span class="hl-value">&quot;json&quot;</span> }
TXT],
        ];
    }
}
