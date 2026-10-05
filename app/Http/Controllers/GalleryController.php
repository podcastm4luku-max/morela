<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index() { return response('Gallery Index Placeholder'); }
    public function create() { return response('Gallery Create Placeholder'); }
    public function store(Request $request) { return response('Gallery Store Placeholder'); }
    public function edit($id) { return response('Gallery Edit Placeholder'); }
    public function update(Request $request, $id) { return response('Gallery Update Placeholder'); }
    public function destroy($id) { return response('Gallery Destroy Placeholder'); }
}
