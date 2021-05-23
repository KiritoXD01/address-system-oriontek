<?php

namespace App\Http\Controllers;

use App\Models\ClientAddress;
use Illuminate\Http\Request;

class ClientAddressController extends Controller
{
    public function create($client)
    {
        return view('clientAddress.create', [
            'client_id' => $client
        ]);
    }

    public function edit(ClientAddress $clientAddress)
    {
        return view('clientAddress.edit', compact('clientAddress'));
    }

    public function store(Request $request)
    {
        return $request->all();
    }

    public function update(Request $request, ClientAddress $clientAddress)
    {
        return $request->all();
    }
}
