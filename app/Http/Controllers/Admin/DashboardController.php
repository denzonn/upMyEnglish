<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Question;
use App\Models\SubMateri;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $materi = Materi::count();
        $subMateri = SubMateri::count();
        $question = Question::count();

        return view('pages.dashboard', compact('materi', 'subMateri', 'question'));
    }
}
