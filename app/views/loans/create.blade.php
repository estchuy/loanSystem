@section('content')
<div class="row">
  <div class="col-lg-6">
    <div class="card-box">
      <h4 class="m-t-0 header-title"><b><i class="md icon-calculator"></i> Calculo de Cuotas - {{$client->name}}</b></h4>
      <form class="form-horizontal" role="form"  data-parsley-validate novalidate action="javascript:calculate({{$client->id}});">
        <div class="form-group">
          <label for="capital" class="col-sm-4 control-label">Capital</label>
          <div class="col-sm-7">
            <input type="text" id="capital" name="capital"  placeholder="Capital" class="form-control" parsley-trigger="change" required>
            <div id="capitaldiv" style="display:none">
              <ul class="parsley-errors-list filled" id="parsley-id-19"><li class="parsley-required">Valor Requerido.</li></ul>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="cuotas" class="col-sm-4 control-label">Tiempo/meses</label>
          <div class="col-sm-3">
            <input id="cuotas" type="text" value="6" name="demo0" data-bts-min="0" data-bts-max="100" data-bts-init-val="" data-bts-step="1" data-bts-decimal="0" data-bts-step-interval="100" data-bts-force-step-divisibility="round" data-bts-step-interval-delay="500" data-bts-prefix="" data-bts-postfix="" data-bts-prefix-extra-class="" data-bts-postfix-extra-class="" data-bts-booster="true" data-bts-boostat="10" data-bts-max-boosted-step="false" data-bts-mousewheel="true" data-bts-button-down-class="btn btn-default" data-bts-button-up-class="btn btn-default"/>
          </div>
          
        </div>
        <div class="form-group">
          <label for="tasa" class="col-sm-4 control-label">Tasa</label>
          <div class="col-sm-7">
            <input type="text" id="tasa" name="tasa"  placeholder="tasa %" class="form-control">
            <div id="tasadiv" style="display:none">
              <ul class="parsley-errors-list filled" id="parsley-id-19"><li class="parsley-required">Valor Requerido.</li></ul>
            </div>
          </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
              <button type="submit" class="btn btn-warning btn-custom waves-effect waves-light">
                <span class="btn-label">
                  <i class="fa fa-calculator"></i>
                </span>
                Proyectar
              </button>
            </div>
          </div>
      </form>
    </div>
  </div>
  <!-- resultado de proyeccion -->
  <div class="col-lg-6">
    <div class="card-box" id="resultCalculo" style="display:hidden">
    </div>
  </div>
</div>
<script type="text/javascript">
  function calculate(client_id){
    document.getElementById("resultCalculo").style.display = 'hidden';
    c = document.getElementById('capital').value;
    i = document.getElementById('tasa').value;
    p = document.getElementById('cuotas').value;
    error = 0;
    
    if(c == ''){
      document.getElementById('capital').className = "form-control parsley-error";
      document.getElementById('capitaldiv').style.display = "block";
      error++;
    }else{
      document.getElementById('capitaldiv').style.display = "none";
      document.getElementById('capital').className = "form-control";
    }
    if(i == ''){
      document.getElementById('tasa').className = "form-control parsley-error";
      document.getElementById('tasadiv').style.display = "block";
      error++;
    }else{
      document.getElementById('tasa').className = "form-control";
      document.getElementById('tasadiv').style.display = "none";
    }
    if(error == 0){
      Im = i/12/100;
      Im2 = Im + 1 ;
      Im2 = Math.pow(Im2, (p*-1));
      cuotaMensual = (Im*c)/(1-Im2);
      cuotaMensual = cuotaMensual.toFixed(2);
      headerTableHtml = '<form method="post" class="form-horizontal tasi-form" id="clientLoan" action="/loan/save">';
      headerTableHtml += '<input type="hidden" id="client_id" name="client_id" value='+client_id+' />';
      headerTableHtml += '<input type="hidden" id="amnt" name="amnt" value='+c+' />';
      headerTableHtml += '<input type="hidden" id="interesGlobal" name="interesGlobal" value='+i+' />';
      headerTableHtml += '<input type="hidden" id="cantidadCuotas" name="cantidadCuotas" value='+p+' />';
      headerTableHtml += '<p></p><button class="btn btn-success btn-custom waves-effect waves-light" onclick="javascript:$(\'#myPleaseWait\').modal(\'show\');" type="submit" form="clientLoan">Crear</button><p></p>';
      headerTableHtml += ' <table class="table table-hover"><thead><tr style="color: #eeeeee;background-color: #517fa4"><th>#</th><th>Cuota Nivelada</th><th>Intereses</th><th>Capital</th><th>Saldo</th></tr></thead><tbody>';
      capital = c;
      ii = 0;
      interesTotal = 0;
      while(ii < p){
        interes = (capital * ((i/100)/12)).toFixed(2);
        interesTotal = parseFloat(interesTotal) + parseFloat(interes);
        capitalMes = (cuotaMensual-interes).toFixed(2);
        capital = (capital - capitalMes).toFixed(2);

        if(capital < 1 && capital > 0){
          interes = parseFloat(interes) + parseFloat(capital);
          interesTotal = parseFloat(interesTotal) + parseFloat(capital);
          capital = (0).toFixed(2);
        }
        if(capital < 0){
          capital = (0).toFixed(2);
        }

        interes = parseFloat(interes).toFixed(2);
        ii++;

        headerTableHtml += '<tr><td>'+ii;
        //hidden values
        headerTableHtml += '<input type="hidden" id="cuotas['+ii+'][cuotaMensual]" name="cuotas['+ii+'][cuotaMensual]" value='+cuotaMensual+' />';
        headerTableHtml += '<input type="hidden" id="cuotas['+ii+'][interes]" name="cuotas['+ii+'][interes]" value='+interes+' />';
        headerTableHtml += '<input type="hidden" id="cuotas['+ii+'][capitalMes]" name="cuotas['+ii+'][capitalMes]" value='+capitalMes+' />';
        headerTableHtml += '<input type="hidden" id="cuotas['+ii+'][capital]" name="cuotas['+ii+'][capital]" value='+capital+' />';
        headerTableHtml += '</td><td>Q '+cuotaMensual+'</td><td>Q '+interes+'</td><td>Q '+capitalMes+'</td><td>Q '+capital+'</td></tr>';
      }
      interesTotal = interesTotal.toFixed(2);
      headerTableHtml += '</tbody></table></form>';
        document.getElementById("resultCalculo").innerHTML = "<strong>Interes Total Q "+interesTotal+"</strong><br>"+headerTableHtml;
        document.getElementById("resultCalculo").style.display = 'block';
    }
  }
</script>
@stop