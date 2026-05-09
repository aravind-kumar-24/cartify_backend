<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registration Completed</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                background-color: #f7f4f1;
                font-family: 'Segoe UI', Arial, sans-serif;
            }

            .registration-completed-email-container {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 60px 20px;
            }

            .registration-completed-mail {
                width: 100%;
                max-width: 560px;
                background: #F5F1EE;
                padding: 40px 45px;
                border-radius: 18px;

                box-shadow: 
                    0 10px 25px rgba(0, 0, 0, 0.08),
                    inset 0 0 0 1px #3275a8;
            }

            .user-name {
                text-align: center;
                color: #3275a8;
                font-size: 32px;
                font-weight: 600;
                margin-bottom: 18px;
            }

            .welcome-message {
                color: #4A4A4A;
                font-size: 20px;
                line-height: 1.6;
                text-align: center;
                margin-bottom: 25px;
            }

            .welcome-message span {
                color: #3275a8;
                font-weight: 700;
            }

            .user-email-verify {
                text-align: center;
            }

            .user-email-verify p {
                color: #4A4A4A;
                font-size: 18px;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            .verify-email-button {
                display: inline-block;
                background: #3275a8;
                color: #ffffff !important;
                text-decoration: none;
                padding: 12px 26px;
                border-radius: 12px;
                font-size: 16px;
                font-weight: 600;
                box-shadow: 0 6px 15px rgba(201, 124, 93, 0.4);
            }

        </style>
    </head>
    <body>
        <div class="registration-completed-email-container">
            <div class="registration-completed-mail">
                <div class="user-name">
                    Hello {{$user_name}}!
                </div>
                <p class="welcome-message">
                    {{ $role == 'buyer' ? 'Buyer' : 'Seller' }} Registration completed successfully. Welcome to <span>Cartify</span>.
                </p>
                <div class="user-email-verify">
                    <p>
                        To complete your registration, please verify your email by clicking the button below:
                    </p>
                    <div>
                        <a href="{{ $url }}" class="verify-email-button">
                            Verify Email
                        </a>
                    </div>  
                </div>
            </div>
        </div>
    </body>
</html>