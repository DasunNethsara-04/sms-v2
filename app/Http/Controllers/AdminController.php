<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // TODO: implement the index method
        return view('pages.admin.dashboard');
    }

    public function create()
    {
        // TODO: implement the create method
    }

    public function store()
    {
        // TODO: implement the store method
    }

    public function show(Admin $admin)
    {
        // TODO: implement the show method
    }

    public function edit(Admin $admin)
    {
        // TODO: implement the edit method
    }

    public function update(Admin $admin)
    {
        // TODO: implement the update method
    }

    public function destroy(Admin $admin)
    {
        // TODO: implement the destroy method
    }
}