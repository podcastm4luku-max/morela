<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CultureController extends Controller
{
    public function index()
    {
        return response('Culture Index Placeholder');
    }

    public function show($slug)
    {
        return response('Culture Show Placeholder');
    }

    public function create()
    {
        return response('Culture Create Placeholder');
    }

    public function store(Request $request)
    {
        return response('Culture Store Placeholder');
    }

    public function edit($id)
    {
        return response('Culture Edit Placeholder');
    }

    public function update(Request $request, $id)
    {
        return response('Culture Update Placeholder');
    }

    public function destroy($id)
    {
        return response('Culture Destroy Placeholder');
    }
}
