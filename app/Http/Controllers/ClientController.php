<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Client;

class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store()
    {
        Client::create(
            Request::validate([
            'name' => ['required'],
            'category' => ['required'],
            'location' => ['required'],
            ])
        );
        return Redirect::route('clients')->with('success', 'Client created.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Client $client)
    {
        $client->update(
            Request::validate([
            'name' => ['required'],
            'category' => ['required'],
            'location' => ['required'],
            ])
        );

        return Redirect::route('clients')->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return Redirect::back()->with('success', 'Client deleted.');
    }

}
