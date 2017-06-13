/*Activa el sistema de eventos MYSQL*/
SET GLOBAL event_scheduler = ON;

/*Evento que mira si hay algun prestamo retrasado y si lo hay lo pasa a la tabla retrasos*/
DROP EVENT IF EXISTS crear_retrasos;
CREATE EVENT crear_retrasos
	ON SCHEDULE EVERY 1 DAY STARTS '2017-06-01 00:00:00'
	DO 
	INSERT INTO retrasos(id_usuario,id_libro,fecha_retraso)
	SELECT id_usuario,id_libro,curdate()
	FROM prestamos
	WHERE fin_prestamo < curdate();

/*Evento que despues de pasar los prestamos retrasados a la tabla retrasos los borra*/
DROP EVENT IF EXISTS borrar_prestamos;
CREATE EVENT borrar_prestamos
	ON SCHEDULE EVERY 1 DAY STARTS '2017-06-01 00:00:05'
	DO 
	DELETE FROM prestamos 
	WHERE fin_prestamo < curdate();

/*Evento que almacena un mensaje en la tabla avisos para mostrar que las reservas han sido elminadas porque tenemos algun retraso*/
DROP EVENT IF EXISTS crear_aviso_retraso;
CREATE EVENT crear_aviso_retraso
	ON SCHEDULE EVERY 1 DAY STARTS '2017-06-01 00:00:10'
	DO 
		INSERT INTO avisos(id_usuario, id_libro,tipo,visto)
        SELECT reservas.id_usuario,reservas.id_libro,'retraso',0
        FROM reservas
        INNER JOIN retrasos
        ON reservas.id_usuario = retrasos.id_usuario;

/*Evento que borra todas las reservas en el momento en que se produce un retraso*/
DROP EVENT IF EXISTS borrar_reservas_retrasos;
CREATE EVENT borrar_reservas_retrasos
	ON SCHEDULE EVERY 1 DAY STARTS '2017-06-01 00:00:15'
	DO 
		DELETE res.* FROM reservas res
        INNER JOIN retrasos ret ON res.id_usuario = ret.id_usuario;


/*Evento que almacena un mensaje en la tabla avisos para mostrar que una reserva ha caducado*/
DROP EVENT IF EXISTS crear_aviso_reserva;
CREATE EVENT crear_aviso_reserva
	ON SCHEDULE EVERY 1 DAY STARTS '2017-06-01 00:00:20'
	DO 
		INSERT INTO avisos(id_usuario,id_libro,tipo,visto)
        SELECT id_usuario, id_libro, 'caducada', 0
        FROM reservas 
        WHERE fin_reserva < curdate();
        
/*Evento que borra las reservas caducadas*/
DROP EVENT IF EXISTS borrar_reservas;
CREATE EVENT borrar_reservas
	ON SCHEDULE EVERY 1 DAY STARTS '2017-06-01 00:00:25'
	DO 
		DELETE FROM reservas
        WHERE fin_reserva < curdate();
        
/*Evento que borra todos los avisos de reserva caducada una vez han sido leidos*/
DROP EVENT IF EXISTS borrar_avisos_leidos;
CREATE EVENT borrar_avisos_leidos
	ON SCHEDULE EVERY 1 DAY STARTS '2017-06-01 00:00:30'
	DO
		DELETE FROM avisos
        WHERE visto =1