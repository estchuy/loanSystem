@section('content')
<title> - Clientes</title>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><i class="md icon-people "></i> <b> Clientes </b></h4>
            <div class="button-list">
	            <a href="/clients/new" type="button" class="btn btn-default btn-rounded waves-effect waves-light">Crear Cliente
	               <span class="btn-label btn-label-right"><i class="icon-user-follow"></i>
	               </span>
	            </a>
        	</div>
        	 <p class="text-muted font-13 m-b-30">
            </p>
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><i class="fa fa-user"></i> Cliente</th>
	                	<th><i class="fa fa-sort-numeric-asc"></i> Prestamos</th>
	                  	<th><i class="fa fa-th"></i> Cuotas</th>
	                  	<th><i class="fa fa-external-link"></i> Intere</th>
	                  	<th><i class="fa fa-money"></i> Total</th>
	                  	<th></th>
                    </tr>
                </thead>
                <tbody>
	              @foreach($clients as $client)	
	              <?php
	              	$loanDetails = Loan::getLoanInfo($client->id);
	              	$countLoans = 0;
	              	$totalLoans = 0;
	              	$totalMonth = 0;
	              	if(isset($loanDetails->count_loan)){
		              	$countLoans = $loanDetails->count_loan;
		              	$totalLoans = $loanDetails->totalLoan;
		              	$totalMonth = $loanDetails->monthly_payment;
		            }
	              ?>
	              	<tr>
		                <td><a href="clients/{{$client->id}}/edit">{{$client->name}}</a></td>
		                <td>{{$countLoans}}</td>
		                <td>Q{{number_format($totalMonth, 2, '.', ',')}}</td>
		                <td>Q{{number_format(Loan::getTotalInteresLoanClient($client->id), 2, '.', ',')}}</td>
		                <td>Q{{number_format($totalLoans, 2, '.', ',')}}</td>
		                <td>
		                	<a href="/loan/{{$client->id}}/new" class="btn btn-icon waves-effect waves-light btn-primary btn-custom" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nuevo Prestamo {{$client->name}}"> <i class="fa fa-plus"></i> </a>
		                	<a href="clients/{{$client->id}}/edit" class="btn btn-icon waves-effect waves-light btn-warning btn-custom" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modificar {{$client->name}}"> <i class="ion-edit"></i> </a>
		                </td>
	              	</tr>
	              	@endforeach
	           	</tbody>
	        </table>
	    </div>
	</div>
</div>
@stop
