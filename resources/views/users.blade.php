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
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Importer des données utilisateurs</button>
            </form>

            <table class="table table-bordered mt-3">
                <tr>
                    <th colspan="3">
                        Liste des utilisateurs
                        <a class="btn btn-primary float-end" href="{{ route('users.export') }}">Exporter des données utilisateurs</a>
                    </th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>

</body>
</html>
