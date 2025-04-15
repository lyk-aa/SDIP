<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Institutions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        .institution {
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }
        .institution h3 {
            margin: 5px 0;
        }
        .institution p {
            margin: 3px 0;
        }
        @media print {
            #printButton {
                display: none; /* Hide button during print */
            }   
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Institutions</h2>
</div>

</body>
</html>
