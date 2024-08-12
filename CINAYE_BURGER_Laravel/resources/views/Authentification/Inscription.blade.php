
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



<form action="{{route('register')}}" method="post">
    @CSRF

    <div>
        <label for="Prenom">Prenom</label>
        <input type="text" name="Prenom" id="Prenom" value="{{old('Prenom')}}" autofocus>
    </div>
    <div>
        <label for="Nom">Nom</label>
        <input type="text" name="Nom" id="Nom" value="{{old('Nom')}}" >
    </div>
    <div>
        <label for="Email">Email</label>
        <input type="email" name="Email" id="Email" value="{{old('Email')}}" >
    </div>
    <div>
        <label for="Mot de passe">Mot de passe</label>
        <input type="password" name="password" id="Mot de passe" value="{{old('Mot de passe')}}">
    </div>

    <div>
        <button type="submit">S'inscrire</button>
    </div>
</form>