<form action="{{ route('admin.livechat.bot.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="input-keyword">Judul (Optional)</label>
        <input type="text" name="bot_judul" class="form-control" id="input-judul-bot" placeholder="Keyword">
    </div>
    @error('bot_judul')
    <div class="validation-error">
        <div class="alert alert-danger" style="width: 100%;">
            {{ $message }}
        </div>
    </div>
    @enderror
    <div class="form-group">
        <label for="input-keyword">Keyword</label>
        <input type="text" name="bot_keyword" class="form-control" id="input-keyword-bot" placeholder="Keyword">
    </div>
    @error('bot_keyword')
    <div class="validation-error">
        <div class="alert alert-danger" style="width: 100%;">
            {{ $message }}
        </div>
    </div>
    @enderror
    <div class="form-group">
        <label for="input-keyword">Prioritas (Optional)</label>
        <input type="text" name="bot_prioritas" class="form-control" id="input-keyword-bot" placeholder="Prioritas">
    </div>
    @error('bot_prioritas')
    <div class="validation-error">
        <div class="alert alert-danger" style="width: 100%;">
            {{ $message }}
        </div>
    </div>
    @enderror
    <div class="form-group">
        <label for="input-text-bot">Text</label>
        <textarea name="bot_chat" class="form-control summernote" id="input-text-bot"></textarea>
    </div>
    @error('bot_chat')
    <div class="validation-error">
        <div class="alert alert-danger" style="width: 100%;">
            {{ $message }}
        </div>
    </div>
    @enderror
    <button type="submit" class="btn btn-primary">Submit</button>
</form>