<!doctype html>
<html>
<head>
    <title>TBC</title>
</head>
<body>

@if(isset($start['error']))
    <h2>Error:</h2>
    <h1>{{ $start['error'] }}</h1>
@elseif(isset($start['TRANSACTION_ID']))
    <form name="returnform" id="Pay" action="https://securepay.ufc.ge/ecomm2/ClientHandler" method="POST">
        <input type="hidden" name="trans_id" value="{{ $start['TRANSACTION_ID'] }}">
    </form>

    <script>
        window.addEventListener('load', function() {
            var form = document.querySelector('form');
            console.log(form);
            form.submit();
        });
    </script>
@endif

</body>
</html>