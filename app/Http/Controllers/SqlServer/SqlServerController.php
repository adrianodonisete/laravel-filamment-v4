<?php

namespace App\Http\Controllers\SqlServer;

use App\Http\Controllers\Controller;
use App\Models\SqlServer\SqlServerModel;
use Illuminate\Contracts\View\View;

class SqlServerController extends Controller
{
    public function index(): View
    {
        $items = (new SqlServerModel())->getTest();

        return view('sqlserver.index', compact('items'));
    }
}
