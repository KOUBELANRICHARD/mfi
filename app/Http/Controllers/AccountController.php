<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPdf\PdfBuilder;
use function Spatie\LaravelPdf\Support\pdf;

class AccountController extends Controller
{
    public function certificate(Account $account): PdfBuilder
    {
        $client = $account->client;
        $name = Client::GENDER[$client->gender] . ' ' . strtoupper($client->name);
        $account_number = $account->account_number;
        // sum all transactions credit - debit for this account
        $transactions = $account->transactions;
        $amount = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->type == 'CREDIT') {
                $amount += $transaction->amount;
            } else {
                $amount -= $transaction->amount;
            }
        }
        $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
        $letter = ucfirst($formatter->format($amount));
        $date = now()->format('d/m/Y');
        // space $amount
        $amount = number_format($amount, 0, ',', ' ');
        Log::info('Certificate data contoller', compact('name', 'account_number', 'amount', 'letter'));
        return pdf('certificate', compact('name', 'account_number', 'amount', 'letter', 'date'));
    }

    public function statement(Account $account): JsonResponse
    {
        $data = session('data');
        Log::info('Statement data contoller', $data);
        return response()->json($account);
    }
}
