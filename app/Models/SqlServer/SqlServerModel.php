<?php

namespace App\Models\SqlServer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SqlServerModel extends Model
{
    protected $connection = 'sqlsrv_local';

    /**
     * @return array<int, object>
     */
    public function getTest(): array
    {
        $query =
            "   SELECT TOP 10 id, cod_prod, origem_produto
                FROM dbo.custom_prod WITH (NOLOCK)
                WHERE id_cli = 11657 AND [status] > 0
                ORDER BY id DESC";

        return DB::connection($this->connection)->select($query);
    }
}
