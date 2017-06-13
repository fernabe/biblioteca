<template>
<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<h2 class="modal-title">Información libro</h2>
		    </div>
		    <div class="modal-body">
		      	<form class="form-horizontal">
			    	
			    	<div class="form-group">
	                    <label for="titulo" class="col-sm-4 control-label">Título:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="nombre" :value="libro.titulo" style="border:none" readonly>
	                    </div>
	                </div>

	               <div class="form-group">
	                    <label for="autor" class="col-sm-4 control-label">Autor:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="autor" :value="libro.autor" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="editorial" class="col-sm-4 control-label">Editorial:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="editorial" :value="libro.editorial" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="Isbn" class="col-sm-4 control-label">Isbn:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="isbn" :value="libro.isbn" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="paginas" class="col-sm-4 control-label">Número de páginas:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="paginas" :value="libro.paginas" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="ejemplares" class="col-sm-4 control-label">Número de ejemplares:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="ejemplares" :value="libro.ejemplares" style="border:none" readonly>
	                        <span class="help-block"><strong></strong></span>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="disponibles" class="col-sm-4 control-label">Ejemplares disponibles:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="disponibles" :value="libro.disponibles" style="border:none" readonly>
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
			libro :{ required:true, type: Object}
		}
	}

</script>