@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('register') }}" method="post">
@csrf
    <input type="text" name="name">
    <input type="text" name="email">
    <input type="password" name="password" >
    <input type="password" name="password_confirmation" >

    <input type="submit" value="">
</form>
