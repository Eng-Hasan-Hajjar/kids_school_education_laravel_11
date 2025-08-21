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
        $monthlyUsers = User::whereMonth('created_at', now()->month)->count();

        // Data for charts
        $sectionsData = Section::withCount('lessons')->get()->map(function ($section) {
            return [
                'name' => $section->Section_Title,
                'lesson_count' => $section->lessons_count
            ];
        })->toArray();

        $userRolesData = User::select('roles.name')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->selectRaw('count(*) as count')
            ->pluck('count', 'roles.name')
            ->toArray();

        $monthlyActivity = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyActivity[] = [
                'month' => $month->format('M Y'),
                'lessons' => Lesson::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'quizzes' => Quiz::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'users' => User::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count()
            ];
        }

        // Latest records
        $latestLessons = Lesson::with('unit.section')->latest()->take(5)->get();
        $latestQuizzes = Quiz::with('unit.section')->latest()->take(5)->get();
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
            'monthlyUsers',
            'sectionsData',
            'userRolesData',
            'monthlyActivity',
            'latestLessons',
            'latestQuizzes',
            'latestUsers'
        ));
    }
}