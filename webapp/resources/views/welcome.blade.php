<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Frete Fácil</title>
</head>
<body>
    <h1>Easy Shipping</h1>
    <p>An easy and performatic way to upload shipping adjustment spreadsheets to some database.</p>
    <h2>Stage 1:</h2>
    <p>Upload the desired shipping adjustment CSV through the web application.</p>
    <form method="POST" action="{{route('upload')}}" enctype="multipart/form-data">
        @csrf
        <input type="file" required name="shipping_csv" id="shipping_csv">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</body>
</html>