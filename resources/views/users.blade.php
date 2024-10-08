<!DOCTYPE html>
<html>
<head>
    <title>Importation/Exportation de données utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Importation/Exportation de données utilisateurs
        </div>
        @if (session('success'))
            <div class="alert alert-success mt-3 mx-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-3 mx-3">
                {{ session('error') }}
            </div>
        @endif
        @error('message')
            <div class="alert alert-err mt-3 mx-3">
                {{ $message }}
            </div>
        @enderror
        @if ($errors->any())
            <div class="alert alert-danger mt-3 mx-3">
                <ul class="my-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form action="{{ route('import.eneamiens.students') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Importer des énéamiens</button>
            </form>

            <form class="mt-3" action="{{ route('import.teachers') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Importer des enseigants</button>
            </form>

            <table class="table table-bordered mt-3">
                <tr>
                    <th colspan="5">
                        Liste des utilisateurs
                        <a class="btn btn-primary float-end" href="{{ route('export.users') }}">Exporter des données utilisateurs</a>
                    </th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th colspan="2">Actions</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        {{-- <td colspan="2">
                            <button class="btn btn-sm btn-warning mx-3">Modifier</button>
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </td> --}}
                    </tr>
                @endforeach
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>

</body>
</html>
