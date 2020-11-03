<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cruds</title>
    <link type="text/css" rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            background-color: #d1d1d1
        }

        #mute {
            position: absolute;
        }

        #mute.on {
            opacity: 0.7;
            z-index: 1000;
            background: white;
            height: 100%;
            width: 100%;
        }

        .highlight {
            font-weight: bold;
            color: #010858;
            background: yellow;
            border: solid 1px #ececec;
        }

        .pagination li {
            margin: 0 10px;
        }

        .pagination li.active a {
            color: #ea677f;
            font-weight: bold;
        }

    </style>
</head>
<script type="text/javascript">
    var base_url = "{{ url('/') . '/' }}";

</script>

<body>
    <div id="mute"></div>
    <div id="app"></div>
    <script src="js/app.js"></script>
</body>

</html>
