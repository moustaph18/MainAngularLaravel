Page Modifcation de burgers

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

<form action="{{route('Modifier')}}" method="post" enctype="multipart/form-data">

@CSRF

    <div>
        <label>Id</label>
        <input type="text" id="id" name="id" value="{{$burgerById->id}}" class="form-control">
    </div>
    <div>
        <label>Image</label>
        <input type="file" id="image" name="image" value="{{$burgerById->Image}}" class="form-control">
    </div>
    <div>
        <label for="Nom">Nom</label>
        <input type="text" name="Nom" id="Nom" value="{{$burgerById->Nom}}" >
    </div>
    <div>
        <label for="Prix">Prix</label>
        <input type="number" name="Prix" id="Prix" value="{{$burgerById->Prix}}" >
    </div>
    <div>
        <label for="description">description</label>
        <textarea type="text" name="description" id="description" >{{$burgerById->Description}} </textarea>
    </div>

    <div>
        <button type="submit">Modifier</button>
    </div>

</form>