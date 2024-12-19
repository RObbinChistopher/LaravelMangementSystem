<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body,
        table,
        td,
        a {
            margin: 0;
            padding: 0;
            font-size: 100%;
            font-family: Arial, sans-serif;
            vertical-align: top;
        }

        table {
            border-spacing: 0;
        }

        td {
            word-wrap: break-word;
        }

        a {
            text-decoration: none;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f2f2f2;
            padding: 20px;
            box-sizing: border-box;
        }

        .email-content {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        .email-header {
            background-color: #99519e;
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }

        .email-header h1 {
            margin: 0;
            font-size: 26px;
            letter-spacing: 1px;
        }

        .email-body {
            color: #333333;
            padding: 20px;
        }

        .email-body h2 {
            color: #333333;
            font-size: 22px;
        }

        .email-body p {
            font-size: 16px;
            margin: 0;
        }

        .email-button {
            background-color: #99519e;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .email-button:hover {
            background-color: #7d3e74;
        }

        .email-footer {
            background-color: #333333;
            color: #ffffff;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-gap: 20px;
            font-size: 14px;
        }

        .footer-section {
            text-align: center;
        }

        .email-footer a {
            color: #ffffff;
        }

        .email-footer p {
            margin: 10px 0;
        }

        @media only screen and (max-width: 600px) {
            .email-content {
                width: 100% !important;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body p {
                font-size: 14px;
            }

            .email-button {
                padding: 10px 18px;
            }

            /* .email-footer {
                grid-template-columns: 1fr !important;
            } */
        }

        .email-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .footer-section {
            text-align: left;
            width: 100%;
        }
    </style>
</head>

<body>
    @yield('content')
    @stack('style')

</body>

</html>