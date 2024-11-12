<x-layout>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <h1>All users</h1>
    <ul>
    @foreach ($users as $user)
        <li><a href="/users/{{$user->id}}">{{$user->name}}</a></li>    
    @endforeach
    </ul>
</x-layout>