/**ARCHIVO QUE EJECUTA LOS EVENTOS AUTOMATICAMENTE SIN NECESIDAD DE PROGRAMARLOS PARA HACER PRUEBAS**/

/*Evento que mira si hay algun prestamo retrasado y si lo hay lo pasa a la tabla retrasos*/
	INSERT INTO retrasos(id_usuario,id_libro,fecha_retraso)
	SELECT id_usuario,id_libro,curdate()
	FROM prestamos
	WHERE fin_prestamo < curdate();

/*Evento que despues de pasar los prestamos retrasados a la tabla retrasos los borra*/
	DELETE FROM prestamos 
	WHERE fin_prestamo < curdate();

/*Evento que almacena un mensaje en la tabla avisos para mostrar que las reservas han sido elminadas porque tenemos algun retraso*/
		INSERT INTO avisos(id_usuario, id_libro,tipo,visto)
        SELECT reservas.id_usuario,reservas.id_libro,'retraso',0
        FROM reservas
        INNER JOIN retrasos
        ON reservas.id_usuario = retrasos.id_usuario;

/*Evento que borra todas las reservas en el momento en que se produce un retraso*/
		DELETE res.* FROM reservas res
        INNER JOIN retrasos ret ON res.id_usuario = ret.id_usuario;


/*Evento que almacena un mensaje en la tabla avisos para mostrar que una reserva ha caducado*/
		INSERT INTO avisos(id_usuario,id_libro,tipo,visto)
        SELECT id_usuario, id_libro, 'caducada', 0
        FROM reservas 
        WHERE fin_reserva < curdate();
        
/*Evento que borra las reservas caducadas*/
		DELETE FROM reservas
        WHERE fin_reserva < curdate();
        
/*Evento que borra todos los avisos de reserva caducada una vez han sido leidos*/
		DELETE FROM avisos
        WHERE visto =1
