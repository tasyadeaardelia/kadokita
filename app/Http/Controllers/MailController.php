<?php

namespace App\Http\Controllers;

use App\Mail\TransferEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;

class MailController extends Controller
{
    public function send($code){

        $transactiondetail = TransactionDetail::with(['transaction', 'product'])->where('code', $code)->first();

        Mail::to($transactiondetail->product->store->user->email)->send(new TransferEmail($transactiondetail));

        return redirect()->route('transfertostore.index');
    }
}
