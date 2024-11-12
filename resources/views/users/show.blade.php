<x-layout>
    <h1>User {{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>Created at: {{ $user->created_at }}</p>
    <p>Updated at: {{ $user->updated_at }}</p>
    <a href="/users/{{$user->id}}/edit" class="btn btn-primary">Edit</a>
    <form action="/users/{{$user->id}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</x-layout>