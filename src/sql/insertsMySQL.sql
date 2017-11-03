USE webAgoraforia;

/*
	*************
	*   USERS   *
	*************
*/

INSERT INTO users(
	nick, 
	password, 
	email, 
	name, 
	surname, 
	date, 
	creation_date, 
	creation_ip, active)
VALUES(
	'jorge', 
	MD5(CONCAT('j' ,'jorge')), 
	'j@j.com', 
	'jorge', 
	'j', 
	'2001-01-01', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO users(
	nick, 
	password, 
	email, 
	name, 
	surname, 
	date, 
	creation_date, 
	creation_ip, active)
VALUES(
	'bbb', 
	MD5(CONCAT('b' ,'bbb')), 
	'j@j.com', 
	'b', 
	'b', 
	'2001-03-04', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO users(
	nick, 
	password, 
	email, 
	name, 
	surname, 
	date, 
	creation_date, 
	creation_ip, active)
VALUES(
	'ccc', 
	MD5(CONCAT('c' ,'ccc')), 
	'c@c.com', 
	'c', 
	'c', 
	'2001-03-04', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

/*
	**************
	*   GROUPS   *
	**************
*/

INSERT INTO groups(
	uid, 
	name, 
	description, 
	creation_date, 
	creation_ip, 
	active)
VALUES(
	1, 
	'DAW', 
	'Grupo de los alumnos de DAW del IES Virgen de la Paloma.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO groups(
	uid, 
	name, 
	description, 
	creation_date, 
	creation_ip, 
	active)
VALUES(
	1, 
	'Pueblo', 
	'Donde nos juntamos los de Losar de la Vera.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO groups(
	uid, 
	name, 
	description, 
	creation_date, 
	creation_ip, 
	active)
VALUES(
	2, 
	'Chavales', 
	'Barrio de Saconia presente.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

/*
	***************
	*   MEMBERS   *
	***************
*/

INSERT INTO members(
	uid, 
	gid) 
VALUES(
	1, 
	3);

INSERT INTO members(
	uid, 
	gid) 
VALUES(
	2, 
	1);

/*
	**************
	*   FORUMS   *
	**************
*/

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'General', 
	'Lugar para tratar los temas de actualidad.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Comunicados', 
	'Aquí es donde debes poner tus sugerencias, quejas o cualquier cosa que desees comunicar a la direcion de la pagina.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Ciencia', 
	'Si te interesa la ciencia este es tu sitio. El lugar hablar de partículas y descubrimientos.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Economía', 
	'Foro para los temas relacionados con la economía o las inversiones.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Historia', 
	'Para aquellos que disfrutan rememorando nuestro pasado.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Política', 
	'Lugar para discutir sobre política e intetar arreglar el mundo.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Deportes', 
	'El lugar para comentar los resultados deportivos.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Motor', 
	'Foro para los amantes del motor y sus deportes relacionados.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Informática', 
	'Si te gusta la informática y los videojuegos este es tu foro.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Electrónica', 
	'Para aquellos a los que les gustan el hardware y los chips.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Televisión', 
	'Si te apetece hablar de tus programas o series de televisión favoritos este es tu lugar.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Cine', 
	'Aquí se reunen los amantes del séptimo arte para intercambiar opiniones.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Literatura', 
	'Para que comentes las obras que conozcas.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Offtopic', 
	'Para aquellos temas que no encajan en ninguna categoría.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Mercadillo', 
	'Si tienes algo que no uses y quieras vender anuncialo aquí.', 
	NULL, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Ejercicios', 
	'Subid aquí las dudas que tengais en los ejercicios de clase.', 
	1, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Proyecto final de curo', 
	'Para que vayamos colgando los progresos en el proyecto de final de curso.', 
	1, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Quedadas', 
	'Para aquellos temas que no encajan en ninguna categoría.', 
	1, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Partidos', 
	'Horarios de los partidos del equipo.', 
	2, 
	TRUE);

INSERT INTO forums(
	name, 
	description, 
	gid, 
	visible) 
VALUES(
	'Viaje de verano', 
	'Para que propongais el destino del viaje de verano.', 
	2, 
	TRUE);

/*
	**************
	*   ADMINS   *
	**************
*/

INSERT INTO admins(
	uid, 
	fid) 
VALUES(
	1, 
	1);

INSERT INTO admins(
	uid, 
	fid) 
VALUES(
	1, 
	2);

INSERT INTO admins(
	uid, 
	fid) 
VALUES(
	2, 
	2);

/*
	*************
	*   POSTS   *
	*************
*/

INSERT INTO posts(
	uid, 
	fid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	1, 
	'Lorem ipsum', 
	'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO posts(
	uid, 
	fid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	1, 'Lorem ipsum 2', 'Al contrario del pensamiento popular, el texto de Lorem Ipsum no es simplemente texto aleatorio. Tiene sus raices en una pieza clásica de la literatura del Latín, que data del año 45 antes de Cristo, haciendo que este adquiera mas de 2000 años de antiguedad. Richard McClintock, un profesor de Latin de la Universidad de Hampden-Sydney en Virginia, encontró una de las palabras más oscuras de la lengua del latín, "consecteur", en un pasaje de Lorem Ipsum, y al seguir leyendo distintos textos del latín, descubrió la fuente indudable. Lorem Ipsum viene de las secciones 1.10.32 y 1.10.33 de "de Finnibus Bonorum et Malorum" (Los Extremos del Bien y El Mal) por Cicero, escrito en el año 45 antes de Cristo. Este libro es un tratado de teoría de éticas, muy popular durante el Renacimiento. La primera linea del Lorem Ipsum, "Lorem ipsum dolor sit amet..", viene de una linea en la sección 1.10.32
El trozo de texto estándar de Lorem Ipsum usado desde el año 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de "de Finibus Bonorum et Malorum" por Cicero son también reproducidas en su forma original exacta, acompañadas por versiones en inglés de la traducción realizada en 1914 por H. Rackham.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO posts(
	uid, 
	fid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	2, 
	'Apolo 11', 
	'Apolo 11 fue la misión espacial que Estados Unidos envió al espacio el 16 de julio de 1969, siendo la primera misión tripulada en llegar a la superficie de la Luna. El Apolo 11 fue impulsado por un cohete Saturno V desde la plataforma LC 39A y lanzado a las 10:32 hora local del complejo de Cabo Kennedy, en Florida (Estados Unidos). Oficialmente se conoció a la misión como AS-506. La misión está considerada como uno de los momentos más significativos de la historia de la Humanidad y la Tecnología.
La tripulación del Apolo 11 estaba compuesta por el comandante de la misión Neil A. Armstrong, de 38 años; Edwin E. Aldrin Jr., de 39 años y piloto del LEM, apodado Buzz; y Michael Collins, de 38 años y piloto del módulo de mando. La denominación de las naves, privilegio del comandante, fue Eagle para el módulo lunar y Columbia para el móulo de mando.
El comandante Neil Armstrong fue el primer ser humano que pisó la superficie de nuestro satélite el 21 de julio de 1969 a las 2:56 (hora internacional UTC) al sur del Mar de la Tranquilidad (Mare Tranquillitatis), seis horas y media después de haber alunizado. Este hito histórico se retransmitió a todo el planeta desde las instalaciones del Observatorio Parkes (Australia). Inicialmente el paseo lunar iba a ser retransmitido a partir de la se�al que llegase a la estación de seguimiento de Goldstone (California, Estados Unidos), perteneciente a la Red del Espacio Profundo, pero ante la mala recepción de la señal se optó por utilizar la señal de la estación Honeysuckle Creek, cercana a Camberra (Australia).1 Ésta retransmitió los primeros minutos del paseo lunar, tras los cuales la señal del observatorio Parkes fue utilizada de nuevo durante el resto del paseo lunar.2 Las instalaciones del MDSCC en Robledo de Chavela (Madrid, España) también pertenecientes a la Red del Espacio Profundo, sirvieron de apoyo durante todo el viaje de ida y vuelta.3 4
El 24 de julio, los tres astronautas lograron un perfecto amerizaje en aguas del Océano Pacífico poniendo fin a la misión.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO posts(
	uid, 
	fid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	16, 
	'Ejercicios del tema 1', 
	'Tengo unas dudillas...', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO posts(
	uid, 
	fid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	17, 
	'¿Cómo lo lleváis el proyecto?', 
	'Me va a pillar el toroooo.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO posts(
	uid, 
	fid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	19, 
	'Copa Marca', 
	'Hay que apuntarse antes del fin de semana.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', TRUE);

/*
	****************
	*   COMMENTS   *
	****************
*/

INSERT INTO comments(
	uid, 
	pid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	1, 
	'Muy interesante', 
	'No lo sabía. Cada día se aprende una cosa nueva.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO comments(
	uid, 
	pid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	2, 
	'Más de lo mismo', 
	'Os estais repitiendo.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO comments(
	uid, 
	pid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	2, 
	'Opino igual', 
	'Opino igual que el comentario anterior. Hay que renovar los temas.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);

INSERT INTO comments(
	uid, 
	pid, 
	title, 
	content, 
	creation_date, 
	creation_ip, 
	visible) 
VALUES(
	1, 
	3, 
	'Pues yo no me lo creo', 
	'Pues yo no me lo creo.', 
	CURRENT_TIMESTAMP(), 
	'127.0.0.1', 
	TRUE);
