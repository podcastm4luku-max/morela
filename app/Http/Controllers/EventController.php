<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return response('Event Index Placeholder');
    }

    public function create()
    {
        return response('Event Create Placeholder');
    }

    public function store(Request $request)
    {
        return response('Event Store Placeholder');
    }

    public function edit($id)
    {
        return response('Event Edit Placeholder');
    }

    public function update(Request $request, $id)
    {
        return response('Event Update Placeholder');
    }

    public function destroy($id)
    {
        return response('Event Destroy Placeholder');
    }
}
