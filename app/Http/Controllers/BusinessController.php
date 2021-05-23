<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::first();
        return $business === null ? view('business.create') : view('business.edit', compact('business'));
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
            $request->logo->move(public_path('images/business'), $logoImage);
            $data['logo'] = 'images/business/'.$logoImage;
        }

        Business::create($data);

        return redirect()->route('business.index')->with('success', trans('messages.itemCreated'));
    }

    public function update(Request $request, Business $business)
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
            $request->logo->move(public_path('images/business'), $logoImage);
            $data['logo'] = 'images/business/'.$logoImage;
        }

        $business->update($data);

        return redirect()->route('business.index')->with('success', trans('messages.itemUpdated'));
    }
}
