@section('content')
<div class="row">
	<div class="col-lg-3"></div>
	<div class="col-lg-6">
		<div class="panel-group" id="accordion-test-2"> 
        	<h4 class="m-t-0 header-title"><i class="fa fa-history"></i><b> Historial de Pagos</b></h4>
        	<?php $i = 1;?>
        	@foreach($history as $data)
        		<?php
        			$totalPay = PayLoan::getTotalPay($data->paymentNumber);
        		?>
        		<div class="panel panel-default panel-color">
		            <div class="panel-heading"> 
		                <h4 class="panel-title"> 
		                    <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseLoan_{{$i}}" aria-expanded="false" class="collapsed">
		                        <i class="fa fa-shopping-bag"></i> Pago 
		                        <i class="fa fa-hashtag"></i> {{$data->paymentNumber}} - 
		                        <b>Q {{number_format($totalPay, 2, '.', ',')}}</b> - 
		                        Fecha de Pago {{substr($data->created_at, 0, 10);}}
		                    </a> 
		                </h4> 
            		</div> 
		            <div id="collapseLoan_{{$i}}" class="panel-collapse collapse"> 
		                <div class="panel-body">
		                  <table class="table-bordered  table table-hover" >
		                    <thead>
		                      <tr style="color: #eeeeee;background-color: #517fa4">
		                     	<th class="text-center"><i class="fa fa-hashtag"></i></th>
			                  	<th><i class="fa fa-user"></i> Cliente</th>
			                  	<th class="text-center"><i class="fa fa-sort-numeric-asc"></i> Cuota</th>
			                  	<th><i class="fa fa-money"></i> Monto</th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                    	<?php 
				              		$ihi = 1;
				              		$loans = PayLoan::gethistory($data->paymentNumber);
				              	?>
				              	@foreach($loans as $loan)
			                        <tr>
					              		<td class="text-center">{{$ihi}}</td>
						                <td>{{$loan->name}}</td>
						                <td class="text-center">{{$loan->period_id."/".$loan->total_of_periods}}</td>
						                <td>Q{{number_format($loan->monthly_payment, 2, '.', ',')}}</td>
					              	</tr>
					              	<?php
					              		$ihi++;
					              	?> 
					           	@endforeach
		                    </tbody>
		                    <thead>
				           		<tr>
				           			<th colspan="3"><strong>Total</strong></th>
				           			<th><strong>Q{{number_format($totalPay, 2, '.', ',')}}</strong></th>
				           		</tr>
				           	</thead>
		                  </table>
		                </div> 
		            </div> 
	          	</div>
	          	<?php $i++;?>
        	@endforeach
        </div>
	</div>
</div>
@stop