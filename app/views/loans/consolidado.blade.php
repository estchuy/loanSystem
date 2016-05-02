@section('content')
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4">
		<div class="card-box table-responsive">
			<table class="table-bordered  table table-hover" >
				<div class="form-group">
			       	<label class="control-label"><h4><i class="fa fa-list-alt "></i> Reporte Consolidado</h4></label>
				</div>
	            <thead>
	              <tr style="color: #eeeeee;background-color: #517fa4">
	                <th><i class="fa fa-sort-numeric-asc"></i> Total Prestamos</th>
		           	<th><i class="fa fa-money"></i> Monto</th>
	              </tr>
	            </thead>
	            <tbody>
	            	<tr>
	            		<td class="text-center"><h4>{{$totalLoans}}</h4></td>
			            <td class="text-center"><h4><strong>Q{{number_format($totalMontly, 2, '.', ',')}}</strong></h4></td>
	            	</tr>
	            </tbody>
	       	</table>
	       	<div>
	        	{{PayLoan::getLastDayPaid()}}
	        </div>
	        <p></p>
	       	<div>
	       		@if(Auth::user()->isSuperUser())
				<form method="post" id="aplicarPago" action="/loan/apply">
					<button class="btn btn-success btn-custom waves-effect waves-light" onclick="javascript:$('#myPleaseWait').modal('show');" type="submit" form="aplicarPago">
						<i class="fa fa-sign-out"></i>
						Aplicar Pago
					</button>
				</form>
				@endif
			</div>
	   	</div>
	</div>
	<div class="col-sm-4"></div>
</div>
@stop