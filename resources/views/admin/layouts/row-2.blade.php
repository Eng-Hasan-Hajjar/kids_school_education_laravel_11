   <div class="container">
        <h1>Admin Dashboard</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Info Boxes -->
        <div class="row">
            <!-- Total Users -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Users</span>
                        <span class="info-box-number">{{ $totalUsers }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Sections -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Sections</span>
                        <span class="info-box-number">{{ $totalSections }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Units -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-folder"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Units</span>
                        <span class="info-box-number">{{ $totalUnits }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Lessons -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-chalkboard"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Lessons</span>
                        <span class="info-box-number">{{ $totalLessons }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Quizzes -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-question-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Quizzes</span>
                        <span class="info-box-number">{{ $totalQuizzes }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Questions -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-clipboard"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Questions</span>
                        <span class="info-box-number">{{ $totalQuestions }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Answers -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Answers</span>
                        <span class="info-box-number">{{ $totalAnswers }}</span>
                    </div>
                </div>
            </div>

            <!-- Monthly Lessons -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Monthly Lessons</span>
                        <span class="info-box-number">{{ $monthlyLessons }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart and Recent Activity -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lessons by Section</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Chart -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <canvas id="lessonsBySectionChart" style="height: 250px;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Latest Lessons -->
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Latest Lessons</h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @forelse($latestLessons as $lesson)
                                                <li class="list-group-item">
                                                    <a href="{{ route('lessons.edit', $lesson->id) }}">{{ $lesson->Lesson_Title }}</a>
                                                    <span class="badge bg-primary float-end">{{ $lesson->unit->section->Section_Title ?? 'N/A' }}</span>
                                                </li>
                                            @empty
                                                <li class="list-group-item">No lessons available.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Latest Quizzes -->
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Latest Quizzes</h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @forelse($latestQuizzes as $quiz)
                                                <li class="list-group-item">
                                                    <a href="{{ route('quizzes.edit', $quiz->id) }}">{{ $quiz->Quiz_Title }}</a>
                                                    <span class="badge bg-primary float-end">{{ $quiz->unit->section->Section_Title ?? 'N/A' }}</span>
                                                </li>
                                            @empty
                                                <li class="list-group-item">No quizzes available.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

