<a href="{{route('Ajout')}}">Ajouter</a> 

<form action="{{route('logout')}}" method="post">
    @CSRF
    <button type="submit">Deconnexion</button>
</form>

@if (session('State')) 
            <div class="alert alert-success col-md-10 mx-auto">
                {{session('State')}}
            </div>
        @endif


@if($listeBurgers->IsEmpty())
    <h4>Pas produit dispo</h4>
@endif
@foreach($listeBurgers as $car)
    <div>
        <img src="{{ asset($car->Image) }}" style="width: 50%; height: 10rem" class="card-img-top" alt="...">
        <h4>{{ $car->Nom }}</h4>
        <h4>{{ $car->Prix }}</h4>
        <h4>{{ $car->Description }}</h4>
        <a href="/Modifier/id={{$car->id}}" class="btn btn-warning">📝</a>
        <a href="/Achivement/id={{$car->id}}" class="btn btn-danger mr-3">❌</a>
    </div>
@endforeach