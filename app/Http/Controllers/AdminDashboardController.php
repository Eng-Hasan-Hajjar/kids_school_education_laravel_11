<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    // قم بتعليق الوسيط مؤقتًا للاختبار
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function dashboard()
    {
     
            // Statistics for the education platform
            $totalUsers = User::count();
            $totalSections = Section::count();
            $totalUnits = Unit::count();
            $totalLessons = Lesson::count();
            $totalQuizzes = Quiz::count();
            $totalQuestions = Question::count();
            $totalAnswers = Answer::count();
            $monthlyLessons = Lesson::whereMonth('created_at', now()->month)->count();
            $monthlyQuizzes = Quiz::whereMonth('created_at', now()->month)->count();

            // Latest records
            $latestLessons = Lesson::with('unit.section')->latest()->take(4)->get();
            $latestQuizzes = Quiz::with('unit.section')->latest()->take(4)->get();
            $latestUsers = User::latest()->take(5)->get();

      
        


            return view('dashboard', compact(
                'totalUsers',
                'totalSections',
                'totalUnits',
                'totalLessons',
                'totalQuizzes',
                'totalQuestions',
                'totalAnswers',
                'monthlyLessons',
                'monthlyQuizzes',
              
                'latestLessons',
                'latestQuizzes',
                'latestUsers',
           
            ));
      
    }
}