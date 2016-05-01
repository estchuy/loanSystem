@section('content')
<script type="text/javascript">
	function calculate(){
		document.getElementById("resultCalculo").style.display = 'hidden';
		c = document.getElementById('capital').value;
		i = document.getElementById('tasa').value;
		p = document.getElementById('cuotas').value;

		Im = i/12/100;
		Im2 = Im + 1 ;
		Im2 = Math.pow(Im2, (p*-1));
		cuotaMensual = (Im*c)/(1-Im2);
		cuotaMensual = cuotaMensual.toFixed(2);
		headerTableHtml = '<p></p><table class="table table-hover"><thead><tr style="color: #eeeeee;background-color: #517fa4"><th>#</th><th>Cuota Nivelada</th><th>Intereses</th><th>Capital</th><th>Saldo</th></tr></thead><tbody>';
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

			ii++;

			headerTableHtml += '<tr><td>'+ii+'</td><td>Q '+cuotaMensual+'</td><td>Q '+interes+'</td><td>Q '+capitalMes+'</td><td>Q '+capital+'</td></tr>';
		}
		interesTotal = interesTotal.toFixed(2);
		headerTableHtml += '</tbody></table>';
	    document.getElementById("resultCalculo").innerHTML = "<strong>Interes Total Q "+interesTotal+"</strong><br>"+headerTableHtml;
	    document.getElementById("resultCalculo").style.display = 'block';
	}
</script>
<div class="row">
  <div class="col-lg-6">
    <div class="card-box">
      <h4 class="m-t-0 header-title"><b><i class="md icon-calculator"></i> Calculo de Cuotas</b></h4>
      <form class="form-horizontal" role="form"  data-parsley-validate novalidate action="javascript:calculate();">
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
@stop