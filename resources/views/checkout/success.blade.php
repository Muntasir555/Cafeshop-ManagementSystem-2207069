<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful — BrewHaven Coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lato', sans-serif; background: #f8faf9; color: #1E3932; text-align: center; padding: 4rem 1rem; margin: 0; }
        .success-box { max-width: 500px; margin: 0 auto; background: #fff; border-radius: 16px; padding: 3rem 2rem; box-shadow: 0 10px 30px rgba(0,98,65,0.08); }
        .success-icon { font-size: 4rem; color: #006241; margin-bottom: 1rem; }
        h1 { margin: 0 0 0.5rem; font-size: 1.8rem; }
        p { color: #5c6b66; line-height: 1.5; margin: 0 0 2rem; }
        .order-number { font-size: 1.25rem; font-weight: 700; color: #006241; background: #d4e9e2; padding: 0.75rem 1.5rem; border-radius: 8px; display: inline-block; margin-bottom: 2rem; }
        .btn-home { display: inline-block; background: #006241; color: #fff; text-decoration: none; padding: 1rem 2rem; border-radius: 999px; font-weight: 700; transition: background 0.2s; }
        .btn-home:hover { background: #00754a; }
    </style>
</head>
<body>
    <div class="success-box">
        <div class="success-icon">✓</div>
        <h1>Payment Successful!</h1>
        <p>Thank you for your order. Your payment has been securely processed and our baristas are preparing your items now.</p>
        
        <div style="font-size:0.9rem; color:#7f8c8d; margin-bottom:0.5rem;">Your Order Number</div>
        <div class="order-number">#{{ $order->id }}</div>
        
        <p style="font-size:0.9rem;">A receipt has been sent to <strong>{{ $order->customer_email }}</strong>.</p>
        
        <a href="{{ route('menu') }}" class="btn-home">Return to Menu</a>
    </div>
</body>
</html>
