@section('content')
<title> - Reporte Detallado</title>
<div class="row">
	<div class="col-sm-2"></div>
    <div class="col-sm-8">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><i class="fa fa-list-alt "></i> <b>  Reporte Detallado </b></h4>
        	 <p class="text-muted font-13 m-b-30">
            </p>
            <form method="post" id="aplicarPago" action="/reporte/apply">
	            <table id="datatable-buttons" class="table table-striped table-bordered">
	                <thead>
	                    <tr>
			            	<th><i class="fa fa-user"></i> Cliente</th>
			               	<th><i class="fa fa-sort-numeric-asc"></i> Cuota</th>
			              	<th><i class="fa fa-money"></i> Monto</th>
			              </tr>
	                </thead>
	                <tbody>
			              	<?php 
			              		$totalPay = 0;
			              		$i = 0;
			              	?>
			              @foreach($loans as $loan)	
			              	<tr>
				                <td>{{$loan->name}}</td>
				                <td>{{$loan->period_id."/".$loan->total_of_periods}}</td>
				                <td>Q{{number_format($loan->monthly_payment, 2, '.', ',')}}</td>
			              	</tr>
			              	<?php
			              		$totalPay = $totalPay + $loan->monthly_payment;
			              		$i++;
			              	?>
			              	@endforeach
			           	</tbody>
			           	<thead>
			           		<tr>
			           			<th colspan="2"><strong>Total</strong></th>
			           			<th>
			           				<strong>Q{{number_format($totalPay, 2, '.', ',')}}</strong>
			           				<input type="hidden" id="total_Loans" value="{{$i}}" name="total_Loans" />
			           			</th>
			           		</tr>
			           	</thead>
		        </table>
		        <div>
		        	<input type="hidden" id="action" name="action" value="detallado">
					<button class="btn btn-success btn-custom waves-effect waves-light" type="submit" form="aplicarPago">
						<i class="fa fa-sign-out"></i>
						Aplicar Pago
					</button>
		       	</div>
		   	</form>
	    </div>
	</div>
</div>
@stop