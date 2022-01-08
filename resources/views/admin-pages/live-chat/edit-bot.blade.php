<div class="modal fade" id="bot-chat-update-{{ $bot->id_chat_bot }}">
    <div class="modal-dialog">
        <form action="{{ route('admin.livechat.bot.update', $bot->id_chat_bot) }}" method="post">
            <div class="modal-content">
                <!-- <div class="overlay">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div> -->
                <div class="modal-header">
                    <h4 class="modal-title">Update Bot {{ $bot->judul ?? $bot->id_chat_bot }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @method('put')
                    @csrf
                    <div class="form-group">
                        <label for="input-judul">Judul (Optional)</label>
                        <input type="text" name="bot_judul" value="{{ $bot->judul }}" class="form-control" id="input-judul-bot-update-{{ $bot->id_chat_bot }}" placeholder="Judul">
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
                        <input type="text" value="{{ $bot->keyword }}" name="bot_keyword" class="form-control" id="input-keyword-bot-update-{{ $bot->id_chat_bot }}" placeholder="Keyword">
                    </div>
                    @error('bot_keyword')
                    <div class="validation-error">
                        <div class="alert alert-danger" style="width: 100%;">
                            {{ $message }}
                        </div>
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="input-prioritas">Prioritas (Optional)</label>
                        <input type="text" value="{{ $bot->prioritas }}" name="bot_prioritas" class="form-control" id="input-prioritas-bot-update-{{ $bot->id_chat_bot }}" placeholder="Prioritas">
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
                        <textarea name="bot_chat" class="form-control summernote" id="input-text-bot-update-{{ $bot->id_chat_bot }}">
                            {{ $bot->chat }}
                        </textarea>
                    </div>
                    @error('bot_chat')
                    <div class="validation-error">
                        <div class="alert alert-danger" style="width: 100%;">
                            {{ $message }}
                        </div>
                    </div>
                    @enderror
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->