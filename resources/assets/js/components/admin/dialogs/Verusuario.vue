<template>
<div class="modal fade text-center">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		    	<h2 class="modal-title">Información usuario</h2>
		    </div>
		    <div class="modal-body">
		       <form class="form-horizontal">
			    	
			    	<div class="form-group">
	                    <label for="nombre" class="col-sm-4 control-label">Nombre:</label>
	                    <div class="col-sm-6">
	                       <input type="text" class="form-control" name="nombre" :value="usuario.nombre" style="border:none" readonly>
	                    </div>
	                </div>

	               <div class="form-group">
	                    <label for="apellido1" class="col-sm-4 control-label">Apellido1:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="apellido1" :value="usuario.apellido1" style="border:none" readonly> 
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="apellido2" class="col-sm-4 control-label">Apellido2:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="apellido2" :value="usuario.apellido2" style="border:none" readonly>    
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="dni" class="col-sm-4 control-label">Dni:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="dni" :value="usuario.dni" style="border:none" readonly>   
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="email" class="col-sm-4 control-label">Email:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="text" :value="usuario.email" style="border:none" readonly>     
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="telefono" class="col-sm-4 control-label">Teléfono:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="telefono" :value="usuario.telefono" style="border:none" readonly>	                         
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="direccion" class="col-sm-4 control-label">Dirección:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="direccion" :value="usuario.direccion" style="border:none" readonly>	                            
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="poblacion" class="col-sm-4 control-label">Población:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="poblacion" :value="usuario.poblacion" style="border:none" readonly>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="reservas" class="col-sm-4 control-label">Reservas:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="reservas" :value="usuario.reservas" style="border:none" readonly>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="prestamos" class="col-sm-4 control-label">Prestamos:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="prestamos" :value="usuario.prestamos" style="border:none" readonly>	                          
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label for="retrasos" class="col-sm-4 control-label">Retrasos:</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" name="retrasos" :value="usuario.retrasos" style="border:none" readonly>	                            
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
			usuario :{ required:true, type: Object}
		}
	}

</script>