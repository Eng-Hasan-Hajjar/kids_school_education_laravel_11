

    <!-- Info Boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">{{ $totalUsers }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Sections</span>
                    <span class="info-box-number">{{ $totalSections }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-folder"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Units</span>
                    <span class="info-box-number">{{ $totalUnits }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-chalkboard"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Lessons</span>
                    <span class="info-box-number">{{ $totalLessons }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-question-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Quizzes</span>
                    <span class="info-box-number">{{ $totalQuizzes }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-secondary"><i class="fas fa-clipboard"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Questions</span>
                    <span class="info-box-number">{{ $totalQuestions }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Answers</span>
                    <span class="info-box-number">{{ $totalAnswers }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Monthly New Users</span>
                    <span class="info-box-number">{{ $monthlyUsers }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Lessons by Section</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="lessonsBySectionChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">User Roles Distribution</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="userRolesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Monthly Activity (Last 6 Months)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="monthlyActivityChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Latest Lessons</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Title</th>
                                <th>Section</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestLessons as $lesson)
                                <tr>
                                    <td class="align-middle">
                                        <a href="{{ route('lessons.edit', $lesson->id) }}">{{ $lesson->Lesson_Title }}</a>
                                    </td>
                                    <td class="align-middle">{{ $lesson->unit->section->Section_Title ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No lessons available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Latest Quizzes</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Title</th>
                                <th>Section</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestQuizzes as $quiz)
                                <tr>
                                    <td class="align-middle">
                                        <a href="{{ route('quizzes.edit', $quiz->id) }}">{{ $quiz->Quiz_Title }}</a>
                                    </td>
                                    <td class="align-middle">{{ $quiz->unit->section->Section_Title ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No quizzes available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        // Lessons by Section Chart
        const lessonsBySectionChart = new Chart(document.getElementById('lessonsBySectionChart'), {
            type: 'bar',
            data: {
                labels: ["Mathematics", "English", "Science", "Art", "Music", "voluptate omnis", "consequatur doloribus", "fuga voluptas", "perspiciatis quaerat", "aut fuga"],
                datasets: [{
                    label: 'Lessons per Section',
                    data: [11, 8, 11, 14, 12, 7, 15, 9, 10, 14],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Lessons'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Sections'
                        }
                    }
                }
            }
        });

         // User Roles Distribution Chart
        const userRolesChart = new Chart(document.getElementById('userRolesChart'), {
            type: 'pie',
            data: {
                labels: @json(array_keys($userRolesData)),
                datasets: [{
                    label: 'User Roles',
                    data: @json(array_values($userRolesData)),
                    backgroundColor: ["rgba(255, 99, 132, 0.6)", "rgba(54, 162, 235, 0.6)", "rgba(255, 206, 86, 0.6)", "rgba(75, 192, 192, 0.6)"],
                    borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(75, 192, 192, 1)"],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });


        // Monthly Activity Chart
        const monthlyActivityChart = new Chart(document.getElementById('monthlyActivityChart'), {
            type: 'line',
            data: {
                labels: ["Mar 2025", "Apr 2025", "May 2025", "Jun 2025", "Jul 2025", "Aug 2025"],
                datasets: [
                    {
                        label: 'Lessons',
                        data: [0, 0, 0, 0, 0, 111],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Quizzes',
                        data: [0, 0, 0, 0, 0, 51],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true
                    },
                    {
                        label: 'New Users',
                        data: [0, 0, 0, 0, 0, 12],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });
    </script>
