<div class="modal fade" id="studentCourseStatusModal" tabindex="-1" role="dialog"
  aria-labelledby="studentCourseStatusModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle" style="font-weight: 700; color; black;">Student Courses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" id="studentCourseStatusModalForm" class="save-student-courses"
          action="{{ route('save.student.courses') }}">
          @csrf
          <input type="hidden" name="user_id" value="{{ $id }}">
          <div class="row pl-2 pr-2 mb-1" style="font-size: 14px; font-weight: 700; color; black;">
            <div class="col-md-6">Learning Path</div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6 text-center">
                  <span class="mr-1">Default</span>
                  <input type="radio" name="learning_path" value="" style="width: 16px; height: 16px;"
                    {{ $student->learning_path ? '' : 'checked' }}>
                </div>
                <div class="col-md-6 text-center">
                  <span class="mr-1">Manual</span>
                  <input type="radio" name="learning_path" value="manual" style="width: 16px; height: 16px;"
                    {{ $student->learning_path == 'manual' ? 'checked' : '' }}>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="row pl-2 pr-2 mb-1" style="font-size: 14px; font-weight: 700; color; black;">
            <div class="col-md-6">Course Name</div>
            <div class="col-md-3 text-center">Is Accessible</div>
            <div class="col-md-3 text-center">Opening Date
            </div>
          </div>
          <hr class="pl-2 pr-2">
          @foreach ($courses as $course)
          <div class="row pl-2 pr-2 mb-1" style="font-size: 14px; font-weight: 600;">
            <div class="col-md-6">
              {{ $course->course_title }}
            </div>
            <input type="hidden" name="courses[{{ $course->id }}][course_id]"
              id="courses_{{ $course->id }}_course_id" value="{{ $course->id }}">
            <div class="col-md-3 text-center">
              <input type="checkbox" name="courses[{{ $course->id }}][is_accessible]"
                id="courses_{{ $course->id }}_is_accessible" value="1"
                {{ $course->users->count() ? 'checked' : '' }}
                {{ $student->learning_path ? '' : 'disabled' }}>
            </div>
            <div class="col-md-3 text-center">
              {{ $course->users->count() ? $course->users[0]->created_at : '' }}
            </div>
          </div>
          @endforeach
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(() => {
    $('input[name="learning_path"]').on('click', function () {
      if (this.checked && this.value === 'manual')
        $('input[id$="_is_accessible"]').attr('disabled', false);
      else
        $('input[id$="_is_accessible"]').attr('disabled', true);
    });
  });
</script>
