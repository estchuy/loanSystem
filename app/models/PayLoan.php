<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PayLoan extends Eloquent {
    use SoftDeletingTrait;
    protected $dates = ["deleted_at"];
    
    protected $fillable = array(
        'loan_id',
        'paymentNumber'
    );

    public static function gethistory($paymentNumber){
    	$history = PayLoan::select('loans.*', 'clients.name')
    	->join('loans', 'loans.id', '=', 'pay_loans.loan_id')
    	->join('clients', 'clients.id', '=', 'loans.client_id')
    	->where('paymentNumber', $paymentNumber)
    	->get();
    	
    	return $history;
    }
    public static function getTotalPay($paymentNumber){
        $pagosDetallado = PayLoan::where('paymentNumber', $paymentNumber)
        ->lists('loan_id');

        $totalPay = Loan::select(DB::raw('sum(monthly_payment) as totalPay'))
        ->whereIn('id', $pagosDetallado)
        ->first();
        
        return $totalPay->totalPay;
    }
    public static function getLastDayPaid(){
        $lastdayPay = PayLoan::orderBy('id', 'desc')
        ->first();
        $string = "";
        if(count($lastdayPay) > 0){
            $string = '<span class="label label-danger">Ultima Fecha de Pago Aplicado '.substr($lastdayPay->created_at, 0, 10).'</span>';
        }
        return $string;
    }
}