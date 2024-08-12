
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



<form action="{{route('login')}}" method="post">
    @CSRF

    <div>
        <label for="Email">Email</label>
        <input type="email" name="Email" id="Email" value="{{old('Email')}}" >
    </div>
    <div>
        <label for="Mot de passe">Mot de passe</label>
        <input type="password" name="password" id="Mot de passe" value="{{old('Mot de passe')}}">
    </div>

    <div>
        <button type="submit">Se Connecter</button>
    </div>
</form>