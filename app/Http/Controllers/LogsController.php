<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogsRequest;
use App\Http\Requests\UpdateLogsRequest;
use App\Models\Logs;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Logs::orderBy('created_at', 'DESC')->get();

        return view('home', ['logs' => $logs]);
    }

    public function create(string $status, string $content)
    {
        $log = new Logs;
        $log->status = $status;
        $log->content = $content;
        $log->save();
    }
}
