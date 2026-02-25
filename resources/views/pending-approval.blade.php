<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval - Tour Base</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #1B2A4A;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            background: #fff;
            color: #1B2A4A;
            border-radius: 16px;
            padding: 48px;
            max-width: 480px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .icon {
            width: 64px;
            height: 64px;
            background: #FDF8ED;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 32px;
        }
        h1 { font-size: 24px; margin-bottom: 12px; }
        p { color: #666; line-height: 1.6; margin-bottom: 24px; }
        .status {
            display: inline-block;
            background: #FDF8ED;
            color: #C4952E;
            padding: 8px 20px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 24px;
        }
        a {
            color: #D4A843;
            text-decoration: none;
            font-weight: 500;
        }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">&#9200;</div>
        <h1>Account Pending Approval</h1>
        <div class="status">Pending Review</div>
        <p>Your registration has been received. An administrator will review and approve your account shortly.</p>
        <p>You will be able to login once your account is approved.</p>
        <a href="/">Back to Home</a>
    </div>
</body>
</html>
