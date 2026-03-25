<?php

namespace Tests\Unit\Ollama;

use App\Services\Ollama\Exceptions\InvalidExpansionResponseException;
use App\Services\Ollama\ProductNameExpansionResponseParser;
use PHPUnit\Framework\TestCase;

class ProductNameExpansionResponseParserTest extends TestCase
{
    private ProductNameExpansionResponseParser $parser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new ProductNameExpansionResponseParser;
    }

    public function test_parses_plain_json(): void
    {
        $out = $this->parser->parse('{"expanded_name":"Paracetamol 500mg 10 comprimidos"}');

        $this->assertSame('Paracetamol 500mg 10 comprimidos', $out);
    }

    public function test_strips_markdown_fence(): void
    {
        $text = "```json\n{\"expanded_name\":\"X\"}\n```";
        $out = $this->parser->parse($text);

        $this->assertSame('X', $out);
    }

    public function test_extracts_json_from_surrounding_text(): void
    {
        $text = 'Here: {"expanded_name":"A b c"} thanks';
        $out = $this->parser->parse($text);

        $this->assertSame('A b c', $out);
    }

    public function test_throws_on_invalid_json(): void
    {
        $this->expectException(InvalidExpansionResponseException::class);
        $this->parser->parse('not json');
    }

    public function test_throws_when_expanded_name_missing(): void
    {
        $this->expectException(InvalidExpansionResponseException::class);
        $this->parser->parse('{"other":"x"}');
    }

    public function test_throws_when_expanded_name_empty(): void
    {
        $this->expectException(InvalidExpansionResponseException::class);
        $this->parser->parse('{"expanded_name":"   "}');
    }
}
