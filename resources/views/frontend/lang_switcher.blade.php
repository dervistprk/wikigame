<div class="form-inline me-3 mt-2 lang-switch-form">
    <label for="lang-selector"></label>
    <select name="locale" class="form-control form-select" id="lang-selector">
        @foreach(config('app.available_locales') as $lang => $code)
            <option class="{{ $code }}" value="{{ $code }}" @if($code == session()->get('locale')) selected="selected" @endif>
                {{ $lang }}
            </option>
        @endforeach
    </select>
</div>