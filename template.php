<html>
    <head>
        <title>MTG Binder</title>
        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.js" integrity="sha256-vtbCELc4mfidIiNdxWDVPvAK5AI86PbpSotyWoGUyxE=" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Kurale|Lora" rel="stylesheet">
        <style>
            @font-face {
                font-family: Beleren;
                src: url('fonts/Beleren-Bold.ttf');
                font-weight:400;
            }
            @font-face {
                font-family: BelerenCaps;
                src: url('fonts/Beleren Small Caps.ttf');
                font-weight:400;
            }
            body {
                background-color: #fde397;
                font-family: 'Lora', serif;
            }
            h1, h2, h3 {
                font-family: 'BelerenCaps', sans-serif;
            }
            .cardlink {
                font-family: 'Beleren', sans-serif;
            }
        </style>
    </head>
    <body>
        <h1>Magic The Gathering Binder</h1>
        <table id='cardtable' border='1' class="tablesorter">
        <?php echo $table; ?>
        </table>
    <script>
        $(function() {
            $("#cardtable").tablesorter({
                theme: 'metro-dark',
                widthFixed: true,
                widgets: ['zebra', 'columns', 'filter']
            });
        });
    </script>
    </body>
</html>