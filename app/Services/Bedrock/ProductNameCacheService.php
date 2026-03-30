<?php

namespace App\Services\Bedrock;

use Illuminate\Support\Facades\Cache;

final class ProductNameCacheService
{
    private const KEY_PREFIX_EXPANSION = 'bedrock_expansion:';

    private const KEY_PREFIX_COMPARE = 'bedrock_compare:';

    /**
     * @return array<string, mixed>|null
     */
    public function get(string $productName, string $option = 'expansion'): ?array
    {
        /** @var array<string, mixed>|null $cached */
        $cached = Cache::get($this->key($productName, $option));

        return $cached;
    }

    /**
     * @param  array<string, mixed>  $result
     */
    public function put(string $productName, array $result, string $option = 'expansion'): void
    {
        $ttl = (int) config('prism.providers.bedrock.expansion_cache_ttl', 86400);

        Cache::put($this->key($productName, $option), $result, $ttl);
    }

    public function forget(string $productName, string $option = 'expansion'): void
    {
        Cache::forget($this->key($productName, $option));
    }

    private function key(string $productName, string $option): string
    {
        $prefix = $option === 'compare'
            ? self::KEY_PREFIX_COMPARE
            : self::KEY_PREFIX_EXPANSION;

        return $prefix . md5(mb_strtolower(trim($productName)));
    }
}
