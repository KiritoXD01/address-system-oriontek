<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('client.index', compact('clients'));
    }

    public function create()
    {
        return view('client.create');
    }

    public function edit(Client $client)
    {
        return view('client.edit', compact('client'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'max:20'],
            'email' => ['nullable', 'string', 'max:255', 'email:rfc'],
            'logo' => ['nullable', 'image']
        ])->validate();

        $data = $request->all();
        $data['email'] = strtolower($data['email']);

        if ($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $logoImage = 'logo.'.$file->getClientOriginalExtension();
            $request->logo->move(public_path('images/clients'), $logoImage);
            $data['logo'] = 'images/clients/'.$logoImage;
        }

        $client = Client::create($data);

        return redirect()->route('client.edit', $client->id)->with('success', trans('messages.itemCreated'));
    }

    public function update(Request $request, Client $client)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'max:20'],
            'email' => ['nullable', 'string', 'max:255', 'email:rfc'],
            'logo' => ['nullable', 'image']
        ])->validate();

        $data = $request->all();
        $data['email'] = strtolower($data['email']);

        if ($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $logoImage = 'logo.'.$file->getClientOriginalExtension();
            $request->logo->move(public_path('images/clients'), $logoImage);
            $data['logo'] = 'images/clients/'.$logoImage;
        }

        $client->update($data);
        return redirect()->route('client.edit', $client->id)->with('success', trans('messages.itemUpdated'));
    }

    public function delete(Client $client)
    {
        $client->delete();
        return redirect()->route('client.index')->with('success', trans('messages.itemDeleted'));
    }
}
