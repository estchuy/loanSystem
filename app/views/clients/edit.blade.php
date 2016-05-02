@section('content')
<script type="text/javascript">
  function switchClassi(){
    div = document.getElementById('loanHistoryDiv').style.display;
    if(div == 'none'){
      document.getElementById('loanHistoryDiv').style.display = 'block';
      document.getElementById('buttonHistorico').innerHTML = '<i class="fa fa-chevron-circle-up"></i> Ocultar';
    }else{
      document.getElementById('loanHistoryDiv').style.display = 'none';
      document.getElementById('buttonHistorico').innerHTML = '<i class="fa fa-chevron-circle-down"></i> Mostrar';
    }
  }
  function validateForm(){
    error = 0;
    if(document.getElementById('nombre').value == ''){
      document.getElementById('nombre').className = "form-control parsley-error";
      document.getElementById('nombrediv').style.display = "block";
      error++;
    }else{
      document.getElementById('nombrediv').style.display = "none";
      document.getElementById('nombre').className = "form-control";
    }
    if(document.getElementById('dpi').value == ''){
      document.getElementById('dpi').className = "form-control parsley-error";
      document.getElementById('dpidiv').style.display = "block";
      error++;
    }else{
      document.getElementById('dpidiv').style.display = "none";
      document.getElementById('dpi').className = "form-control";
    }
    if(document.getElementById('address').value == ''){
      document.getElementById('address').className = "form-control parsley-error";
      document.getElementById('addressdiv').style.display = "block";
      error++;
    }else{
      document.getElementById('addressdiv').style.display = "none";
      document.getElementById('address').className = "form-control";
    }
    if(document.getElementById('phone').value == ''){
      document.getElementById('phone').className = "form-control parsley-error";
      document.getElementById('phonediv').style.display = "block";
      error++;
    }else{
      document.getElementById('phonediv').style.display = "none";
      document.getElementById('phone').className = "form-control";
    }
    filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(document.getElementById('email').value == ''){
      document.getElementById('email').className = "form-control parsley-error";
      document.getElementById('emaildiv').style.display = "block";
      document.getElementById('emaildivemail').style.display = "none";
      error++;
    }else{
      if(filter.test(document.getElementById('email').value)){
        document.getElementById('emaildivemail').style.display = "none";
        document.getElementById('emaildiv').style.display = "none";
        document.getElementById('email').className = "form-control";
      }else{
        document.getElementById('emaildivemail').style.display = "block";
        document.getElementById('emaildiv').style.display = "none";
        document.getElementById('email').className = "form-control parsley-error";
        error++;
      }
    }

    if(error > 0){
      return false;
    }else{
      $('#myPleaseWait').modal('show');
    }
  }
</script>
<link href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/packages/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
<div class="row">
  <div class="col-lg-6">
    <div class="card-box">
      <h4 class="m-t-0 header-title"><b><i class="fa fa-user"></i> Cliente - {{$client->name or 'Nuevo'}}</b></h4>
      <form method="post" class="form-horizontal tasi-form" id="clientInfo" action="/client/save" onsubmit="return validateForm()">
            <div class="form-group">
                  <label class="col-md-2 control-label" for="nombre">Nombre</label>
                  <div class="col-md-10">
                    <input type="hidden" id="id" name="id" value="{{$client->id or 0}}" />
                    <input type="text" id="nombre" name="nombre"  placeholder="Nombre" value="{{$client->name or ''}}" class="form-control">
                    <div id="nombrediv" style="display:none">
                      <ul class="parsley-errors-list filled" id="parsley-id-19"><li class="parsley-required">Valor Requerido.</li></ul>
                    </div>
                  </div>
            </div>
            <div class="form-group">
                  <label class="col-md-2 control-label">DPI</label>
                  <div class="col-md-10">
                    <input type="text" id="dpi" name="dpi" data-mask="9999 99999 9999" placeholder="Documento Personal de Identificacion" value="{{$client->personal_id or ''}}" class="form-control round-form">
                    <div id="dpidiv" style="display:none">
                      <ul class="parsley-errors-list filled" id="parsley-id-19"><li class="parsley-required">Valor Requerido.</li></ul>
                    </div>
                  </div>
            </div>
            <div class="form-group">
                  <label class="col-md-2 control-label">Direccion</label>
                  <div class="col-md-10">
                    <input type="text" id="address" name="address"  placeholder="Direccion" value="{{$client->address or ''}}" class="form-control round-form">
                    <div id="addressdiv" style="display:none">
                      <ul class="parsley-errors-list filled" id="parsley-id-19"><li class="parsley-required">Valor Requerido.</li></ul>
                    </div>
                  </div>
            </div>
            <div class="form-group">
                  <label class="col-md-2 control-label">Telefono</label>
                  <div class="col-md-10">
                    <input type="text" id="phone" name="phone" data-mask="9999-9999" placeholder="Telefono" value="{{$client->phone or ''}}" class="form-control round-form">
                    <div id="phonediv" style="display:none">
                      <ul class="parsley-errors-list filled" id="parsley-id-19"><li class="parsley-required">Valor Requerido.</li></ul>
                    </div>
                  </div>
            </div>
            <div class="form-group">
                  <label class="col-md-2 control-label">Email</label>
                  <div class="col-md-10">
                    <input type="text" id="email" name="email"  placeholder="Direccion de Correo Electronico" value="{{$client->email or ''}}" class="form-control round-form">
                    <div id="emaildiv" style="display:none">
                      <ul class="parsley-errors-list filled" id="parsley-id-19"><li class="parsley-required">Valor Requerido.</li></ul>
                    </div>
                    <div id="emaildivemail" style="display:none">
                      <ul class="parsley-errors-list filled" id="parsley-id-19"><li class="parsley-required">Tiene que ser un Email valido.</li></ul>
                    </div>
                  </div>
            </div>

            <div class="form-group text-right m-b-0">
              @if(Auth::user()->isSuperUser())
                <button class="btn btn-primary waves-effect waves-light btn-custom" type="submit" form="clientInfo">
                  <i class="fa fa-save"> </i> Guardar
                </button>
                @if(isset($client))
                  <a class="btn btn-success btn-custom waves-effect waves-light" onclick="javascript:$('#myPleaseWait').modal('show');" href="/loan/{{$client->id}}/new">
                    <i class="fa fa-plus"> </i> Crear Prestamo
                  </a>
                @endif
              @endif
            </div>
        </form>
      </div>
    </div>
    <div class="col-lg-6">
      @if(isset($edit))
      <div class="panel-group" id="accordion-test-2"> 
        <h4 class="m-t-0 header-title"><b>Historial de Prestamos</b></h4>
        <?php $i = 1;?>
        @foreach($loans as $loan)
          <div class="panel panel-default panel-color">
            <div class="panel-heading"> 
                <h4 class="panel-title"> 
                    <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseLoan_{{$i}}" aria-expanded="false" class="collapsed">
                        <i class="fa fa-shopping-bag"></i> Prestamo # {{$i}} - <strong>Q{{number_format($loan->amnt, 2, '.', ',')}}</strong>
                    </a> 
                </h4> 
            </div> 
            <div id="collapseLoan_{{$i}}" class="panel-collapse collapse"> 
                <div class="panel-body">
                  <table class="table-bordered  table table-hover" >
                    <thead>
                      <tr style="color: #eeeeee;background-color: #517fa4">
                        <th>Plazo</th>
                        <th>Cuotas</th>
                        <th>Interes</th>
                        <th>Capital</th>
                        <th>Saldo</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php
                              $loanDetails = Loan::getDetailLoans($loan->id);
                            ?>
                            @foreach($loanDetails as $loanDetail) 
                              <tr>
                                <td class="text-center">{{$loanDetail->period_id}}</td>
                                <td>Q{{number_format($loanDetail->monthly_payment, 2, '.', ',')}}</td>
                                <td>Q{{number_format($loanDetail->interest_fee, 2, '.', ',')}}</td>
                                <td>Q{{number_format($loanDetail->capital, 2, '.', ',')}}</td>
                                <td>Q{{number_format($loanDetail->balance, 2, '.', ',')}}</td>
                                <td>
                                  @if($loanDetail->pay == 0)
                                    <span class="badge bg-important">Pendiente</span>
                                  @else
                                    <span class="badge bg-success">Pagado</span>
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                    </tbody>
                  </table>
                </div> 
            </div> 
          </div>
        <?php $i++;?>
        @endforeach
      </div>
    </div>
    @endif
  </div>
@stop
