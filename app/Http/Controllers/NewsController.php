<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index() { return response('News Index Placeholder'); }
    public function show($slug) { return response('News Show Placeholder'); }
    public function create() { return response('News Create Placeholder'); }
    public function store(Request $request) { return response('News Store Placeholder'); }
    public function edit($id) { return response('News Edit Placeholder'); }
    public function update(Request $request, $id) { return response('News Update Placeholder'); }
    public function destroy($id) { return response('News Destroy Placeholder'); }
}
