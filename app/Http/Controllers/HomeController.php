<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $classrooms = DB::table('class__members')
            ->join('classrooms', function ($join) {
                $join->on('class__members.class_id', '=', 'classrooms.id')
                    ->where('class__members.user_id', auth()->user()->id);
            })
            ->select('class__members.is_teacher', 'classrooms.id', 'classrooms.title')
            ->orderBy('class__members.created_at', 'desc')
            ->get();

        $manage_classrooms = $classrooms->where('is_teacher', true);

        $participate_classrooms = $classrooms->where('is_teacher', false);

        return view('home', [
            'manage_classrooms'      => $manage_classrooms,
            'participate_classrooms' => $participate_classrooms
        ]);
    }
}
