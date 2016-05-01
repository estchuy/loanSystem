<?php

class LoansController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$client = Client::find($id);
		
		$this->layout->content = View::make('loans.create')            
		->with('client', $client);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		foreach(Input::get('cuotas') as $period_id => $cuota){
			$p = new Loan();
			$p->client_id = Input::get('client_id');
  			$p->amnt = Input::get('amnt');
  			$p->period_id = $period_id;
  			$p->monthly_payment = $cuota['cuotaMensual'];
  			$p->interest = Input::get('interesGlobal');
  			$p->interest_fee = $cuota['interes'];
  			$p->capital = $cuota['capitalMes'];
  			$p->balance = $cuota['capital'];
  			if($period_id > 1){
  				$p->parent_id = $parent_id;
  			}
  			$p->pay = 0;
  			$p->total_of_periods = Input::get('cantidadCuotas');

  			$p->save();
  			if($period_id == 1){
  				$parent_id = $p->id;

  				$p->parent_id = $p->id;
  				$p->save();
  			}
		}

		Session::flash('notification', 'Creado y Asociado a Cliente');
    	Session::flash('color', 'success');
    	Session::flash('area', 'Prestamo');

    	return Redirect::to("/clients");
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function consolidado()
	{
		$loans = Loan::where('pay', 0)
		->groupBy('parent_id')
		->get();

		$totalMontly = 0;
		$totalInteres = 0;
		$totalCapital = 0;
		$i = 0;

		foreach ($loans as $loan) {
			$totalMontly = $totalMontly + $loan->monthly_payment;
			$totalInteres = $totalInteres + $loan->interest_fee;
			$totalCapital = $totalCapital + $loan->capital;
			$i++;
		}
		
		$this->layout->content = View::make('loans.consolidado')            
		->with('totalMontly', $totalMontly)
		->with('totalInteres', $totalInteres)
		->with('totalCapital', $totalCapital)
		->with('totalLoans', $i);

	}

	public function detallado()
	{
		$loans = Loan::select('loans.*', 'clients.name')
		->join('clients', 'clients.id', '=', 'loans.client_id')
		->where('loans.pay', 0)
		->groupBy('loans.parent_id')
		->orderBy('clients.name', 'asc')
		->orderBy('loans.parent_id', 'asc')
		->get();

		$this->layout->content = View::make('loans.detallado')            
		->with('loans', $loans);
	}

	public function periodo()
	{
		//
	}

	public function applyPayment(){

		$paymentNumber = 1;

		$number = PayLoan::groupBy('paymentNumber')
		->orderBy('paymentNumber', 'desc')
		->first();

		if(count($number) > 0){
			$paymentNumber = $number->paymentNumber+1;
		}

		if(Input::get('action') == 'consolidado'){
			$loans = Loan::select('loans.*')
			->where('loans.pay', 0)
			->groupBy('loans.parent_id')
			->orderBy('loans.parent_id', 'asc')
			->get();

			foreach ($loans as $loan) {

				$pLoan = Loan::find($loan->id);
				$pLoan->pay = 1;
				$pLoan->save();

				$p = new PayLoan();
				$p->loan_id = $loan->id;
				$p->paymentNumber = $paymentNumber;
				$p->save();
			}
		}else{
			$i = 0;
			while($i < Input::get('total_Loans')){
				if(Input::get($i) !== null ){
					$pLoan = Loan::find(Input::get('loan_id_'.$i));
					$pLoan->pay = 1;
					$pLoan->save();

					$p = new PayLoan();
					$p->loan_id = $pLoan->id;
					$p->paymentNumber = $paymentNumber;
					$p->save();
				}
			}
		}

		Session::flash('notification', 'Aplicado Correctamente');
    	Session::flash('color', 'success');
    	Session::flash('area', 'Pago');

    	return Redirect::to("/historico");
	}

	public function history(){
		$history = PayLoan::groupBy('paymentNumber')
		->get();

		$this->layout->content = View::make('loans.history')            
		->with('history', $history);
	}

	public function download(){
		$optionsMpdf[0] = 0;
		$optionsMpdf[1] = 1;
	 	//if you want a different option from default
		//$optionsMpdf[2] = 'left text, center text, right text'
		if(Input::get('action') == 'consolidado'){
			$loans = Loan::where('pay', 0)
			->groupBy('parent_id')
			->get();

			$totalMontly = 0;
			$totalInteres = 0;
			$totalCapital = 0;
			$i = 0;

			foreach ($loans as $loan) {
				$totalMontly = $totalMontly + $loan->monthly_payment;
				$totalInteres = $totalInteres + $loan->interest_fee;
				$totalCapital = $totalCapital + $loan->capital;
				$i++;
			}
			$html = '<table border="0">
	          			<tr>
	          				<th colspan="2" align="center">
	          					<h4>Reporte Consolidado</h4>
	          				</th>
	          			</tr>
	          			<tr>
	          				<td colspan="2">
	          					<hr>
	          				</td>
	          			</tr>
			            <tr>
			              	<th> Total Prestamos</th>
			               	<th> Monto</th>
			            </tr>
			            <tr>
				          	<td style="padding-left:60px"><h4>'.$i.'</h4></td>
				         	<td><h4><strong>Q'.number_format($totalMontly, 2, '.', ',').'</strong></h4></td>
			            </tr>
			        </table>';
			$name = "Consolidado_".date('Y_m_d');
		}elseif (Input::get('action') == 'detallado') {
			$loans = Loan::select('loans.*', 'clients.name')
			->join('clients', 'clients.id', '=', 'loans.client_id')
			->where('loans.pay', 0)
			->groupBy('loans.parent_id')
			->orderBy('clients.name', 'asc')
			->orderBy('loans.parent_id', 'asc')
			->get();

			$html = '<table border="0">
							<tr>
		          				<th colspan="4" align="center">
		          					<h4>Reporte Detallado</h4>
		          				</th>
		          			</tr>
		          			<tr>
		          				<td colspan="4">
		          					<hr>
		          				</td>
		          			</tr>
		              		<tr>
		              			<th>#</th>
		                  		<th>Cliente</th>
		                  		<th>Cuota</th>
		                  		<th>Monto</th>
		              		</tr>';
		   	$i = 1;
		   	$totalPay = 0;
			foreach ($loans as $loan) {
				$html .= '<tr>
							<td>'.$i.'</td>
			                <td>'.$loan->name.'</td>
			                <td>'.$loan->period_id.'/'.$loan->total_of_periods.'</td>
			                <td>Q'.number_format($loan->monthly_payment, 2, '.', ',').'</td>
		              	</tr>';
		      	$i++;
		      	$totalPay = $totalPay + $loan->monthly_payment;
			}

			$html .= '<thead>
		           		<tr>
		           			<th colspan="3"><strong>Total</strong></th>
		           			<th><strong>Q'.number_format($totalPay, 2, '.', ',').'</strong></th>
		           		</tr>
		           	</thead>
		          </table>';
			$name = "Detallado_".date('Y_m_d');
		}

		PDFcreate::createPDF($html, $optionsMpdf, $name);
	}

}
