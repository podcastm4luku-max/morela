<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index()
    {
        return response('UMKM Index Placeholder');
    }

    public function show($id)
    {
        return response('UMKM Show Placeholder');
    }

    public function create()
    {
        return response('UMKM Create Placeholder');
    }

    public function store(Request $request)
    {
        return response('UMKM Store Placeholder');
    }

    public function edit($id)
    {
        return response('UMKM Edit Placeholder');
    }

    public function update(Request $request, $id)
    {
        return response('UMKM Update Placeholder');
    }

    public function destroy($id)
    {
        return response('UMKM Destroy Placeholder');
    }
}
