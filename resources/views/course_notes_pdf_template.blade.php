<!DOCTYPE html>
<html>
<head>
    <title>Course Notes</title>
    <style>
        /* Define your CSS styles here */
        /* Add any additional styling you require */
        
        @page {
            margin: 50px 50px;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
        }

        .chapter-title {
            text-align: center;
            margin-top: 10px;
        }

        .lesson-title {
            margin-top: 20px;
        }

        .lesson-note {
            margin-bottom: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .course-title {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Course Title -->
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="center">
        <h1>Course Title</h1>
        <h1 class="course-title">{{ $course->course_title }}</h1>
    </div>

    @foreach($course->chapters as $chapter)
        <div class="page-break"></div> <!-- Page break after each chapter -->

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <!-- Chapter Title -->
        <div class="center">
            <h2 class="course-title">Chapter {{ $loop->iteration }}</h2>
            <h2 class="chapter-title">{{ $chapter->title }}</h2>
        </div>

        @foreach($chapter->lessons as $lesson)
            <div class="page-break"></div> <!-- Page break after each lesson -->

            <!-- Lesson Title -->
            <h3 class="lesson-title">Lesson: {{ $lesson->title }}</h3>

            <!-- Lesson Note -->
            <div class="lesson-note">
                <p>{{ isset($lesson->notes[0]->notes) && strlen($lesson->notes[0]->notes) ? $lesson->notes[0]->notes : 'Notes not available for this Lesson.' }}</p>
            </div>
        @endforeach
    @endforeach
</body>
</html>
