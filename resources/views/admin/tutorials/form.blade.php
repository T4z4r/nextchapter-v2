<x-admin-shell title="{{ $item->exists ? 'Edit tutorial' : 'New tutorial' }}">
  <x-admin-form back="{{ route('admin.tutorials.index') }}" action="{{ $item->exists ? route('admin.tutorials.update', $item->id) : route('admin.tutorials.store') }}" enctype="multipart/form-data">
    @if($item->exists)@method('PUT')@endif
    <div class="tp-split">
      <div class="tp-fields">
        <div class="field">
          <label for="title">Title</label>
          <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" required>
        </div>
        <x-wysiwyg name="description" label="Description" :value="$item->description">
          <span class="hint">Lead paragraph under the title. Rich text supported.</span>
        </x-wysiwyg>
        <div class="form-cols">
          <div class="field">
            <label for="duration">Duration</label>
            <input id="duration" type="text" name="duration" value="{{ old('duration', $item->duration) }}" placeholder="4:12">
          </div>
          <div class="field">
            <label for="sort">Sort order</label>
            <input id="sort" type="number" name="sort" value="{{ old('sort', $item->sort ?? 0) }}" min="0">
          </div>
        </div>

        <h2>Media (optional)</h2>
        <div class="field">
          <label for="image">Thumbnail image</label>
          @if($item->image_path)
            <img src="{{ $item->imageUrl() }}" alt="Current thumbnail" class="tp-current-img">
          @endif
          <x-dropzone name="image" label="Drop thumbnail image here" accept="image/png,image/jpeg,image/webp,image/gif"/>
          <span class="hint">JPG, PNG, WebP or GIF, up to 5 MB. Shown behind the play button.</span>
          @error('image')<span class="hint" style="color:#B3402D">{{ $message }}</span>@enderror
          @if($item->image_path)
            <div class="check-row">
              <input id="remove_image" type="checkbox" name="remove_image" value="1">
              <label for="remove_image">Remove current image</label>
            </div>
          @endif
        </div>
        <div class="field">
          <label for="video">Video file</label>
          @if($item->video_path)
            <video class="tp-current-video" src="{{ $item->videoUrl() }}" controls preload="metadata"></video>
            <span class="hint">Current: {{ basename($item->video_path) }}</span>
          @endif
          <x-dropzone name="video" label="Drop video file here" accept="video/mp4,video/webm,video/ogg,video/quicktime"/>
          <span class="hint">MP4, WebM, OGG or MOV, up to 20 MB. Unlocked tutorials play it in a lightbox on the public site.</span>
          @error('video')<span class="hint" style="color:#B3402D">{{ $message }}</span>@enderror
          @if($item->video_path)
            <div class="check-row">
              <input id="remove_video" type="checkbox" name="remove_video" value="1">
              <label for="remove_video">Remove current video</label>
            </div>
          @endif
        </div>

        <div class="check-row">
          <input id="is_locked" type="checkbox" name="is_locked" value="1" {{ old('is_locked', $item->is_locked ?? true) ? 'checked' : '' }}>
          <label for="is_locked">Locked preview (shows padlock + “After purchase”)</label>
        </div>
        <div class="check-row">
          <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
          <label for="is_active">Visible on site</label>
        </div>
      </div>

      <aside class="tp-live">
        <h3>Live preview</h3>
        <p class="hint">Exactly how this card appears on the public site.</p>
        @include('admin.partials.tutorial-card', [
          'index' => ($item->sort ?? 0) + 1,
          'title' => $item->title ?? '',
          'description' => $item->description,
          'duration' => $item->duration,
          'locked' => $item->is_locked ?? true,
          'imageUrl' => $item->image_path ? $item->imageUrl() : null,
        ])
      </aside>
    </div>

    <script>
      (function () {
        var card = document.querySelector('.tp-live [data-tp-card]');
        if (!card) return;

        var bind = function (id, fn) {
          var el = document.getElementById(id);
          if (!el) return;
          fn(el);
          el.addEventListener('input', function () { fn(el); });
          el.addEventListener('change', function () { fn(el); });
        };

        var rt = card.querySelector('.rt');
        var syncDescription = function () {
          var hidden = document.getElementById('editor-description');
          if (hidden && rt) rt.innerHTML = hidden.value;
        };

        bind('title', function (el) {
          card.querySelector('.body h4').textContent = el.value;
        });

        bind('duration', function (el) {
          var dur = card.querySelector('.dur');
          dur.textContent = el.value;
          dur.style.display = el.value ? '' : 'none';
        });

        bind('is_locked', function (el) {
          card.classList.toggle('locked', el.checked);
        });

        var imgInput = document.getElementById('image');
        if (imgInput) {
          imgInput.addEventListener('change', function () {
            var file = imgInput.files && imgInput.files[0];
            var img = card.querySelector('.tp-img');
            if (file) {
              if (!img) {
                img = document.createElement('img');
                img.className = 'tp-img';
                img.alt = '';
                card.querySelector('.tp-thumb').prepend(img);
              }
              img.src = URL.createObjectURL(file);
            }
          });
        }

        document.addEventListener('trix-change', syncDescription);
        syncDescription();
      })();
    </script>
  </x-admin-form>
</x-admin-shell>
