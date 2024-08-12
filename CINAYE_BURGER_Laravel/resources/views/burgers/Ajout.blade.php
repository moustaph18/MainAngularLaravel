
Page Ajout de burgers

@if($errors->any())
    <div>
        <div>something went wrong</div>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{route('Ajout')}}" method="post" enctype="multipart/form-data">

@CSRF


    <div>
        <label>Image</label>
        <input type="file" id="image" name="image" class="form-control">
    </div>
    <div>
        <label for="Nom">Nom</label>
        <input type="text" name="Nom" id="Nom" value="{{old('Nom')}}" >
    </div>
    <div>
        <label for="Prix">Prix</label>
        <input type="number" name="Prix" id="Prix" value="{{old('Prix')}}" >
    </div>
    <div>
        <label for="description">description</label>
        <textarea type="text" name="description" id="description" value="{{old('description')}}"></textarea>
    </div>

    <div>
        <button type="submit">Ajouter</button>
    </div>

</form>