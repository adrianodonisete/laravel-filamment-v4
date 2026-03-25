<?php

namespace Tests\Feature\Api;

use App\Services\Ollama\OllamaGenerateClient;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class OllamaExpandProductNameTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_expand_product_name_returns_success_payload(): void
    {
        $mock = Mockery::mock(OllamaGenerateClient::class);
        $mock->shouldReceive('generate')
            ->once()
            ->andReturn([
                'response' => '{"expanded_name":"Paracetamol 500mg 10 comprimidos"}',
            ]);
        $this->app->instance(OllamaGenerateClient::class, $mock);

        $response = $this->postJson('/api/ollama/expand-product-name', [
            'product_name' => 'Paracetamol 500mg 10cmp',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'original' => 'Paracetamol 500mg 10cmp',
                'expanded_name' => 'Paracetamol 500mg 10 comprimidos',
            ]);

        $this->assertArrayNotHasKey('raw', $response->json());
    }

    public function test_expand_product_name_includes_raw_when_app_debug(): void
    {
        config(['app.debug' => true]);

        $mock = Mockery::mock(OllamaGenerateClient::class);
        $mock->shouldReceive('generate')
            ->once()
            ->andReturn([
                'response' => '{"expanded_name":"X"}',
            ]);
        $this->app->instance(OllamaGenerateClient::class, $mock);

        $response = $this->postJson('/api/ollama/expand-product-name', [
            'product_name' => 'Test',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['original', 'expanded_name', 'model', 'raw']);
    }

    public function test_expand_product_name_returns_422_when_model_output_invalid(): void
    {
        $mock = Mockery::mock(OllamaGenerateClient::class);
        $mock->shouldReceive('generate')
            ->once()
            ->andReturn(['response' => 'not valid json']);
        $this->app->instance(OllamaGenerateClient::class, $mock);

        $response = $this->postJson('/api/ollama/expand-product-name', [
            'product_name' => 'Paracetamol 500mg 10cmp',
        ]);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Não foi possível interpretar a resposta do modelo.']);
    }

    public function test_expand_product_name_returns_502_when_ollama_client_fails(): void
    {
        $mock = Mockery::mock(OllamaGenerateClient::class);
        $mock->shouldReceive('generate')
            ->once()
            ->andThrow(new RuntimeException('connection refused'));
        $this->app->instance(OllamaGenerateClient::class, $mock);

        $response = $this->postJson('/api/ollama/expand-product-name', [
            'product_name' => 'Paracetamol 500mg 10cmp',
        ]);

        $response->assertStatus(502)
            ->assertJsonFragment(['message' => 'O serviço de IA não está disponível. Tente novamente.']);
    }

    public function test_expand_product_name_returns_422_when_product_name_missing(): void
    {
        $response = $this->postJson('/api/ollama/expand-product-name', []);

        $response->assertStatus(422);
        $errors = $response->json('errors.product_name');
        $this->assertIsArray($errors);
        $this->assertNotEmpty($errors);
    }
}
