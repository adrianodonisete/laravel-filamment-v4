<?php

namespace App\Services\Bedrock;

use Illuminate\Support\Facades\Cache;

final class ExpansionCacheService
{
    private const KEY_PREFIX = 'bedrock_expansion:';

    /**
     * @return array<string, mixed>|null
     */
    public function get(string $productName): ?array
    {
        /** @var array<string, mixed>|null $cached */
        $cached = Cache::get($this->key($productName));

        return $cached;
    }

    /**
     * @param  array<string, mixed>  $result
     */
    public function put(string $productName, array $result): void
    {
        $ttl = (int) config('prism.providers.bedrock.expansion_cache_ttl', 86400);

        Cache::put($this->key($productName), $result, $ttl);
    }

    public function forget(string $productName): void
    {
        Cache::forget($this->key($productName));
    }

    private function key(string $productName): string
    {
        return self::KEY_PREFIX . md5(mb_strtolower(trim($productName)));
    }
}
