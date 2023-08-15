<?php

namespace App\Http\Controllers;

class BookController extends Controller
{
    public function index(){
        return response()->json(['app_name' => 'book_service', 'status' => 'OK']);
    }
}
