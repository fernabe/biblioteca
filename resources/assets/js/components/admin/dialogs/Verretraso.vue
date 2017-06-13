<template>
<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<h2 class="modal-title">Información retraso</h2>
		    </div>
		    <div class="modal-body">
		      	<form class="form-horizontal">

		      		<div class="form-group">
	                    <label for="titulo" class="col-sm-4 control-label">Usuario:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="titulo" v-bind:value="retraso.nombre+' '+retraso.apellido1" style="border:none" readonly>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="titulo" class="col-sm-4 control-label">Dni:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="titulo" :value="retraso.dni" style="border:none" readonly>
	                    </div>
	                </div>
			    	
			    	<div class="form-group">
	                    <label for="titulo" class="col-sm-4 control-label">Título:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="titulo" :value="retraso.titulo" style="border:none" readonly>
	                    </div>
	                </div>

	               	<div class="form-group">
	                    <label for="autor" class="col-sm-4 control-label">Autor:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="autor" :value="retraso.autor" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="editorial" class="col-sm-4 control-label">Editorial:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="editorial" :value="retraso.editorial" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="Isbn" class="col-sm-4 control-label">Isbn:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="isbn" :value="retraso.isbn" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="Isbn" class="col-sm-4 control-label">Fecha retraso:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="isbn" :value="retraso.fecha_retraso" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                 <div class="form-group">
	                    <label for="Isbn" class="col-sm-4 control-label">Días retraso:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="isbn" :value="retraso.dias_retraso" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
			   			<button id="cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Volver</button>
		    		</div> 

			    </form>
		    </div>  
		</div>
  	</div>
</div>
</template>

<script>

	export default {

		props : {
			retraso :{ required: true, type: Object}
		}
	}

</script>