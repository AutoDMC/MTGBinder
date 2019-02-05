<html>
    <head>
        <title>MTG Binder</title>
        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>
        <script
                src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.js"
                integrity="sha256-vtbCELc4mfidIiNdxWDVPvAK5AI86PbpSotyWoGUyxE="
                crossorigin="anonymous"></script>
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/css/theme.metro-dark.min.css"
              integrity="sha256-XPXQD55OWfeuLqGkbIJMEj3lunYhNtZUlY8cZDEcP34="
              crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/widgets/widget-filter.min.js"
                integrity="sha256-1dNFnpGK7o5XmrnR9pK+ZU4yNLyBn1GAbNr8ijAJ1xw="
                crossorigin="anonymous"></script>
        <script src="https://unpkg.com/tippy.js@3/dist/tippy.all.min.js"></script>
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/css/theme.materialize.min.css"
              integrity="sha256-Ins/1wFNaW8KmsbOJp2VK2/P11CRAA8iJ6AvZRsXSzw="
              crossorigin="anonymous" />
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
            .cardbox {
                background-color: black;
                padding: 5px;
                border-radius: 10px;
            }
            .footer {
                clear: both;
                color: white;
                font-family: 'BelerenCaps', sans-serif;
            }
            tfoot td {
                font-family: 'BelerenCaps', sans-serif !important;
                font-size: 20px !important;
            }
            .cardlink {
                font-family: 'Beleren', sans-serif;
                font-size: small;
            }
            .tippy-tooltip {
                padding: 0;
                background-color: black;
            }
        </style>
    </head>
    <body>
        <h1>Magic The Gathering Binder</h1>
        <div class="cardbox">
            <table id='cardtable' class="tablesorter">
                <thead>
                    <tr>
                        <th class='filter-select'>Trade?</th>
                        <th>Name</th>
                        <th class='filter-select'>Set</th>
                        <th class='filter-select'>Rarity</th>
                        <th class='filter-select'>Foil?</th>
                        <th class='filter-select'>Q</th>
                        <th>Colors</th>
                        <th>Mana Cost</th>
                        <th>Type</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <?php echo $table; ?>
            </table>
            <div class="footer">This horrible HTML made with shame by Shawn Boles</div>
        </div>
    <script>
        $(function() {
            $("#cardtable").tablesorter({
                theme: 'materialize',
                widthFixed: true,
                widgets: ['zebra', 'filter'],
                widgetOptions: {
                    filter_ignoreCase : true,
                    filter_columnFilters : true
                }
            });
        });
    </script>
    </body>
</html>