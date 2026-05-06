<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Email Verification Completed</title>
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

            .email-verification-container {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 60px 20px;
            }

            .email-verification {
                width: 100%;
                max-width: 560px;
                background: #F5F1EE;
                padding: 40px 45px;
                border-radius: 18px;

                box-shadow: 
                    0 10px 25px rgba(0, 0, 0, 0.08),
                    inset 0 0 0 1px #3275a8;
            }

            .welcome-message {
                text-align: center;
                color: #3275a8;
                font-size: 32px;
                font-weight: 600;
                margin-bottom: 18px;
            }

        </style>
    </head>
    <body>
        <div class="email-verification-container">
            <div class="email-verification">
                <p class="welcome-message">
                    Email Verified Successfully.
                </p>
            </div>
        </div>
    </body>
</html>