<!DOCTYPE html>
<html>
<head>
    <title>KADOKITA</title>
</head>
<body>
  
    <h1>Dear, {{ $transactiondetail->product->store->name }}</h1>
    <p>Selamat, transaksi {{ $transactiondetail->transaction->code }} telah berhasil dilakukan oleh 
        {{ $transactiondetail->transaction->user->fullname }} dan dana telah dicairkan ke rekening anda.
        Silahkan cek rekening, dan segera selesaikan pengiriman anda, Terimakasih!
    </p>
   
    <p>KADOKITA</p>
</body>
</html>