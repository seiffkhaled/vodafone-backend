<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Navbar Styles */
        .navbar {
            background-color: blue;
            color: white;
            padding: 15px;
            display: flex;
            margin: 10px 10px 10px 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            align-items: center;
        }

        .title {
            width: 100%;
            /* flex: 1; */
            text-align: left;
            font-size: 0.9rem;

        }

        .myTitle {
            margin-top: 10px;
        }

        .logo {
            max-width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .p {
            width: 100%;
            /* flex: 1; */
            text-align: left;
            font-size: 0.9rem;
        }

        /* Container Styles */
        .container {
            display: block;
            align-items: center;
            background-color: white;
            margin: 10px 10px 10px 10px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .content {
            line-height: 2;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                /* text-align: center; */
            }

            .myTitle {
                font-size: 14px;
                margin-top: 20px;
            }

            .logo img {
                max-width: 50px;
                height: 50px;
                object-fit: cover;
            }

            .container {
                width: 100%;
                margin: 0;
                padding: 10px;
            }

            .content {
                font-size: 0.9rem;
            }

            h3 {
                font-size: 1rem;
            }

            p {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 400px) {
            .navbar {
                padding: 10px;
            }

            .title {
                font-size: 15px;
            }

            .logo img {
                max-width: 40px;
            }

            .container {
                /* padding: 10px; */
            }

            h3 {
                font-size: 0.9rem;
            }

            p {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="title">
            <h2 class="myTitle">{{__('notifications.Egypt_Customs_Authority')}}</h2>
        </div>
        <div class="logo">
            <img src="https://customs.gov.eg/content/images/EcaLogoLarge.png" alt="logo" class="logo">
        </div>
    </div>
    <div class="container">
        <div class="content">
            <h3>{{ $header ?? '' }}</h3>
                @if (isset($bodyLines) &&  count($bodyLines) > 0 )
                    @foreach ($bodyLines as $line)
                        <p>{!! $line !!}</p>
                    @endforeach
                @endif
            <h3>{{ $footer ?? '' }}</h3>
        </div>
        <p>{{__('notifications.Regards')}}<br>{{__('notifications.Egypt_Customs_Authority')}}</p>
    </div>
</body>
</html>
