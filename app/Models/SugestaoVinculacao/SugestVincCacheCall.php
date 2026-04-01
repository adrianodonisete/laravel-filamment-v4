<?php

namespace App\Models\SugestaoVinculacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SugestVincCacheCall extends Model
{
    protected $connection = 'sqlsrv_local';

    protected $table = 'systax_app.dbo.sugest_vinc_cache_call';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'chave',
        'conteudo',
        'dt_criacao',
    ];

    private const CONNECTION = 'sqlsrv_local';

    /**
     * @return array<string, mixed>|null
     */
    public static function getOne(string $chave): ?object
    {
        $query =
            '   SELECT id, chave, conteudo, dt_criacao
                FROM systax_app.dbo.sugest_vinc_cache_call WITH (NOLOCK)
                WHERE chave = :chave';

        /** @var object|null $rs */
        return collect(DB::connection(self::CONNECTION)->select($query, ['chave' => $chave]))
            ->first();
    }

    /**
     * @param  array<string, mixed>|object  $conteudo
     */
    public static function saveByChave(string $chave, array|object $conteudo): void
    {
        $json = json_encode(
            is_array($conteudo) ? $conteudo : (array) $conteudo,
            JSON_UNESCAPED_UNICODE
        );

        /** @var static|null $existing */
        $existing = static::on(self::CONNECTION)->where('chave', $chave)->first();

        if ($existing !== null) {
            $existing->conteudo = $json;
            $existing->dt_criacao = DB::raw('GETDATE()');
            $existing->save();
        } else {
            static::on(self::CONNECTION)->create([
                'chave' => $chave,
                'conteudo' => $json,
                'dt_criacao' => DB::raw('GETDATE()'),
            ]);
        }
    }

    public static function deleteByChave(string $chave): void
    {
        static::on(self::CONNECTION)->where('chave', $chave)->delete();
    }
}
