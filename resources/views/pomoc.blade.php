<!DOCTYPE html>
<html>

<head>
    <title>Potwierdzenie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 400px;
            margin: 100px auto;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>E-mail z potwierdzeniem został wysłany.</p>
        <a href="{{ route('welcome') }}">Przejdź na stronę główną</a>
    </div>
</body>
</html>
