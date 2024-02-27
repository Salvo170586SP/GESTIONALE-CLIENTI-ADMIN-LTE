<div class="d-flex">
    <div class="mb-5 mr-3 d-flex flex-column">
        <label for="title_note" class="mb-3">
            Titolo
        </label>
        <input id="title_note" value="{{ old('title_note', isset($note) ? $note->title_note : '') }}" type="text" name="title_note" class="form-control" />
    </div>
    <div class="mb-5  d-flex flex-column">
        <label for="date" class="mb-3">
            Data
        </label>
        <input type="date" value="{{ old('date', isset($note) ? $note->date : '') }}" name="date" id="date" class="form-control" />
    </div>
</div>

<div class="mb-5">
    <label for="editor" class="mb-3">
        Testo
    </label>
    <textarea id="editor" type="text" name="text_note" class="form-control">{!! old('text_note', isset($note) ? $note->text_note : '') !!}</textarea>
</div>
