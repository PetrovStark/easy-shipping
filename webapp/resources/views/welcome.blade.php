<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <title>Easy Shipping</title>
</head>
<body>
    <style>
        pre, code {
            font-family: monospace, monospace;
        }
        pre {
            overflow: auto;
        }
        pre > code {
            display: block;
            padding: 1rem;
            word-wrap: normal;
        }
    </style>
    <div class="screen">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        <h1>Easy Shipping</h1>
        <p>An easy and performatic way to upload shipping adjustment spreadsheets to some database.</p>
        <h2>Stage 1:</h2>
        <p>Upload the desired shipping adjustment CSV through the web application.</p>
        <form method="POST" action="{{route('upload')}}" enctype="multipart/form-data">
            @csrf
            <input type="file" required name="shipping_csv" id="shipping_csv">
            <input type="submit" value="Upload Image" name="submit">
        </form>

        @if(isset($_GET['show_stage_two']) && (bool) $_GET['show_stage_two'] == true)
            <h2>Stage 2:</h2>
            <p>Check the imported data. Access the database to see the imported data. You can find the credentials in the <strong>docker-compose.yml</strong> file, or just copy it from here.</p>
            <ul>
                <li>Host:127.0.0.1</li>
                <li>Port:4406</li>
                <li>User: root</li>
                <li>Password: mauFJcuf5dhRMQrjj</li>
                <li>Database: frete_facil_db</li>
            </ul>
            <p>Run this query to see the imported data.</p>
            <figure>
                <pre>
                  <code contenteditable spellcheck="false">SELECT * FROM spreadsheets;</code>
                </pre>
              </figure>
        @endif
    </div>
</body>
</html>