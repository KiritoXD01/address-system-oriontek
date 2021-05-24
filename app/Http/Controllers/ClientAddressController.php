<?php

namespace App\Http\Controllers;

use App\Models\ClientAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        Validator::make($request->all(), [
            'address' => ['required', 'string', 'max:500'],
            'client_id' => ['required', 'integer']
        ])->validate();

        $clientAddress = ClientAddress::create($request->all());

        return redirect()->route('clientAddress.edit', $clientAddress->id)->with('success', trans('messages.itemCreated'));
    }

    public function update(Request $request, ClientAddress $clientAddress)
    {
        Validator::make($request->all(), [
            'address' => ['required', 'string', 'max:500']
        ])->validate();

        $clientAddress->update($request->all());

        return redirect()->route('clientAddress.edit', $clientAddress->id)->with('success', trans('messages.itemUpdated'));
    }

    public function delete(ClientAddress $clientAddress)
    {
        $client_id = $clientAddress->client_id;
        $clientAddress->delete();

        return redirect()->route('client.edit', $client_id)->with('success', trans('messages.itemDeleted'));
    }
}
