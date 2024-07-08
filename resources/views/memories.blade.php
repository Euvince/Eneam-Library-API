<!DOCTYPE html>
<html>
<head>
    <title>Importation de fiches de dépôts de mémoires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Importation de fiches de dépôts de mémoires
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
            <form action="{{ route('import.pdfs.reports') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="files[]" class="form-control" multiple>
                <br>
                <button class="btn btn-success">Importer des fiches(pdfs)</button>
            </form>

            <form class="mt-3" action="{{ route('import.words.reports') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="files[]" class="form-control" multiple>
                <br>
                <button class="btn btn-success">Importer des fiches(words)</button>
            </form>

            <table class="table table-bordered mt-3">
                <tr>
                    <th colspan="3">
                        Liste des mémoires soutenus
                    </th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Thème</th>
                    <th>Premier auteur</th>
                    <th>Deuxième auteur</th>
                    <th>Maître mémoire</th>
                    <th>Président du jury</th>
                </tr>
                @foreach($memories as $memory)
                    <tr>
                        <td>{{ $memory->id }}</td>
                        <td>{{ $memory->theme }}</td>
                        <td>{{ $memory->first_author_firstname }}</td>
                        <td>{{ $memory->second_author_firstname }}</td>
                        <td>{{ $memory->memory_master_name }}</td>
                        <td>{{ $memory->jury_president_name }}</td>
                    </tr>
                @endforeach
            </table>
            {{ $memories->links() }}
        </div>
    </div>
</div>

</body>
</html>
