    <div class="mb-2 form-group">
        <label for="name_client" class="mb-1">
            Nome
        </label>
        <input   type="text" value="{{ old('name_client', isset($client) ? $client->name_client : '') }}" name="name_client" id="name_client" class="error form-control" />
        @error('name_client')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-2 form-group">
        <label for="surname_client" class="mb-1">
            Cognome
        </label>
        <input  type="text" name="surname_client" value="{{ old('surname_client', isset($client) ? $client->surname_client : '') }}" id="surname_client" class="error form-control" />
        @error('surname_client')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-2">
        <label for="date_of_birth" class="mb-1">
            Data di nascita
        </label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($client) ? $client->date_of_birth : '') }}" id="date_of_birth" class="form-control" />
    </div>

    <div class="mb-2">
        <label for="city_of_birth" class="mb-1">
            Città di nascita
        </label>
        <input type="text" name="city_of_birth" id="city_of_birth" value="{{ old('city_of_birth', isset($client) ? $client->city_of_birth : '') }}" class="form-control" />
    </div>


    <div class="mb-2">
        <label for="address" class="mb-1">
            Indirizzo
        </label>
        <input type="text" name="address" value="{{ old('address', isset($client) ? $client->address : '') }}" id="address" class="form-control" />
    </div>

    <div class="mb-4">
        <label for="cap" class="mb-1">
            CAP
        </label>
        <input type="text" name="cap" id="cap" value="{{ old('cap', isset($client) ? $client->cap : '') }}" class="form-control" />
    </div>
    <div class="mb-4">
        <label for="file" class="mb-1">
            Allega immagine profilo
        </label>
        <input type="file" name="file_url" id="file" class="form-control" />
    </div>
