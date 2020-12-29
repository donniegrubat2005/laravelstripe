<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
    }

    public function transaction()
    {
        $sample_data = [
            'firstname'   => 'Donnie',
            'lastname'    => 'Grubat'
        ];

        return response()->json($sample_data);
    }
}
