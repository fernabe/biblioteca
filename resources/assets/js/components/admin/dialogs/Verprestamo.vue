<template>
<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<h2 class="modal-title">Información préstamo</h2>
		    </div>
		    <div class="modal-body">
		      	<form class="form-horizontal">

		      		<div class="form-group">
	                    <label for="titulo" class="col-sm-4 control-label">Usuario:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="titulo" v-bind:value="prestamo.nombre+' '+prestamo.apellido1" style="border:none" readonly>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="titulo" class="col-sm-4 control-label">Dni:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="titulo" :value="prestamo.dni" style="border:none" readonly>
	                    </div>
	                </div>
			    	
			    	<div class="form-group">
	                    <label for="titulo" class="col-sm-4 control-label">Título:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="titulo" :value="prestamo.titulo" style="border:none" readonly>
	                    </div>
	                </div>

	               	<div class="form-group">
	                    <label for="autor" class="col-sm-4 control-label">Autor:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="autor" :value="prestamo.autor" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="editorial" class="col-sm-4 control-label">Editorial:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="editorial" :value="prestamo.editorial" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="Isbn" class="col-sm-4 control-label">Isbn:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="isbn" :value="prestamo.isbn" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="Isbn" class="col-sm-4 control-label">Fin préstamo:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="isbn" :value="prestamo.fin_prestamo" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="Isbn" class="col-sm-4 control-label">Caduca en:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="isbn" v-bind:value="prestamo.caduca+' días'" style="border:none" readonly>
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
			prestamo :{ required: true, type: Object}
		}
	}

</script>