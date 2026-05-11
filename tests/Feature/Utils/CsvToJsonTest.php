<?php

declare(strict_types=1);

namespace Tests\Feature\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CsvToJsonTest extends TestCase
{
    public function test_index_page_renders_form(): void
    {
        $response = $this->get(route('utils.csv-to-json.index'));

        $response->assertStatus(200);
        $response->assertSee('Conversor CSV para JSON');
        $response->assertSee('<form', false);
    }

    public function test_store_with_csv_text_success(): void
    {
        Storage::fake('public');

        $csvContent = "product,description,price\nProduct A,Description A,10.00";

        $response = $this->post(route('utils.csv-to-json.store'), [
            'csv_text' => $csvContent,
        ]);

        $response->assertRedirect(route('utils.csv-to-json.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('download_url');
    }

    public function test_store_with_csv_file_success(): void
    {
        Storage::fake('public');

        $csvContent = "product,description,price\nProduct B,Description B,20.00";
        $file = UploadedFile::fake()->createWithContent('test.csv', $csvContent);

        $response = $this->post(route('utils.csv-to-json.store'), [
            'csv' => $file,
        ]);

        $response->assertRedirect(route('utils.csv-to-json.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('download_url');
    }

    public function test_store_without_fields_fails(): void
    {
        $response = $this->post(route('utils.csv-to-json.store'), []);

        $response->assertSessionHasErrors(['csv', 'csv_text']);
    }

    public function test_store_with_both_fields_fails(): void
    {
        $response = $this->post(route('utils.csv-to-json.store'), [
            'csv_text' => 'product,description\nA,B',
            'csv' => UploadedFile::fake()->create('test.csv', 100),
        ]);

        $response->assertSessionHasErrors(['csv', 'csv_text']);
    }

    public function test_csv_parsing_produces_correct_json(): void
    {
        Storage::fake('public');

        $csvContent = "product,description,price\nProduct A,Description A,10.00\nProduct B,,20.00";

        $response = $this->post(route('utils.csv-to-json.store'), [
            'csv_text' => $csvContent,
        ]);

        $response->assertRedirect(route('utils.csv-to-json.index'));

        $files = Storage::disk('public')->files('utils');
        $this->assertNotEmpty($files);

        $content = Storage::disk('public')->get($files[0]);
        $json = json_decode($content, true);

        $this->assertArrayHasKey('data', $json);
        $this->assertCount(2, $json['data']);
        $this->assertEquals('Product A', $json['data'][0]['product']);
        $this->assertEquals('Description A', $json['data'][0]['description']);
        $this->assertEquals('10.00', $json['data'][0]['price']);
        $this->assertNull($json['data'][1]['description']);
    }
}
