<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled — BrewHaven Coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lato', sans-serif; background: #f8faf9; color: #1E3932; text-align: center; padding: 4rem 1rem; margin: 0; }
        .cancel-box { max-width: 500px; margin: 0 auto; background: #fff; border-radius: 16px; padding: 3rem 2rem; box-shadow: 0 10px 30px rgba(200,32,20,0.08); border-top: 4px solid #c82014; }
        .cancel-icon { font-size: 4rem; margin-bottom: 1rem; }
        h1 { margin: 0 0 0.5rem; font-size: 1.8rem; }
        p { color: #5c6b66; line-height: 1.5; margin: 0 0 2rem; }
        .btn-home { display: inline-block; background: #1E3932; color: #fff; text-decoration: none; padding: 1rem 2rem; border-radius: 999px; font-weight: 700; transition: background 0.2s; }
        .btn-home:hover { background: #2a4c43; }
    </style>
</head>
<body>
    <div class="cancel-box">
        <div class="cancel-icon">⚠️</div>
        <h1>Payment Cancelled</h1>
        <p>You have cancelled the checkout process. Your order has not been placed and your card was not charged.</p>
        
        <a href="{{ route('menu') }}" class="btn-home">Return to Menu</a>
    </div>
</body>
</html>
