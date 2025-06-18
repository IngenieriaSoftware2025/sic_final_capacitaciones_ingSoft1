CREATE TABLE kvsc_usuario(
usuario_id SERIAL PRIMARY KEY,
usuario_nom1 VARCHAR (50) NOT NULL,
usuario_nom2 VARCHAR (50) NOT NULL,
usuario_ape1 VARCHAR (50) NOT NULL,
usuario_ape2 VARCHAR (50) NOT NULL,
usuario_tel INT NOT NULL, 
usuario_direc VARCHAR (150) NOT NULL,
usuario_dpi VARCHAR (13) NOT NULL,
usuario_correo VARCHAR (100) NOT NULL,
usuario_contra LVARCHAR (1056) NOT NULL,
usuario_token LVARCHAR (1056) NOT NULL,
usuario_fecha_creacion DATE DEFAULT TODAY,
usuario_fecha_contra DATE DEFAULT TODAY,
usuario_fotografia LVARCHAR (2056),
usuario_situacion SMALLINT DEFAULT 1
);

CREATE TABLE kvsc_aplicacion(
app_id SERIAL PRIMARY KEY,
app_nombre_largo VARCHAR (250) NOT NULL,
app_nombre_medium VARCHAR (150) NOT NULL,
app_nombre_corto VARCHAR (50) NOT NULL,
app_fecha_creacion DATE DEFAULT TODAY,
app_situacion SMALLINT DEFAULT 1
);

CREATE TABLE kvsc_permiso(
permiso_id SERIAL PRIMARY KEY, 
permiso_app_id INT NOT NULL,
permiso_nombre VARCHAR (150) NOT NULL,
permiso_clave VARCHAR (250) NOT NULL,
permiso_desc VARCHAR (250) NOT NULL,
permiso_fecha DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
permiso_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (permiso_app_id) REFERENCES kvsc_aplicacion(app_id)
);

CREATE TABLE kvsc_asig_permisos(
asignacion_id SERIAL PRIMARY KEY,
asignacion_usuario_id INT NOT NULL,
asignacion_app_id INT NOT NULL,
asignacion_permiso_id INT NOT NULL,
asignacion_fecha DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
asignacion_quitar_fechapermiso DATETIME YEAR TO SECOND DEFAULT CURRENT YEAR TO SECOND,
asignacion_usuario_asigno INT NOT NULL,
asignacion_motivo VARCHAR (250) NOT NULL,
asignacion_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (asignacion_usuario_id) REFERENCES kvsc_usuario(usuario_id),
FOREIGN KEY (asignacion_app_id) REFERENCES kvsc_aplicacion(app_id),
FOREIGN KEY (asignacion_permiso_id) REFERENCES kvsc_permiso(permiso_id)
);

CREATE TABLE kvsc_rutas(
ruta_id SERIAL PRIMARY KEY,
ruta_app_id INT NOT NULL,
ruta_nombre LVARCHAR (1056) NOT NULL,
ruta_descripcion VARCHAR (250) NOT NULL,
ruta_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (ruta_app_id) REFERENCES kvsc_aplicacion(app_id)
);

CREATE TABLE kvsc_historial_act(
historial_id SERIAL PRIMARY KEY,
historial_usuario_id INT NOT NULL,
historial_fecha DATETIME YEAR TO MINUTE,
historial_ruta INT NOT NULL,
historial_ejecucion LVARCHAR (1056) NOT NULL,
historial_status INT,
historial_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (historial_usuario_id) REFERENCES kvsc_usuario(usuario_id),
FOREIGN KEY (historial_ruta) REFERENCES kvsc_rutas(ruta_id)
);

--------------------- TABLAS PARA LA APLICACION --------------------------------
-- 1. TABLA INSTRUCTORES
CREATE TABLE kvsc_instructor(
instructor_id SERIAL PRIMARY KEY,
instructor_nombres VARCHAR (100) NOT NULL,
instructor_apellidos VARCHAR (100) NOT NULL,
instructor_grado VARCHAR (50) NOT NULL,
instructor_arma VARCHAR (100) NOT NULL,
instructor_telefono INT NOT NULL,
instructor_situacion SMALLINT DEFAULT 1
);


-- 2. TABLA COMPAÑÍAS
CREATE TABLE kvsc_compania(
compania_id SERIAL PRIMARY KEY,
compania_nombre VARCHAR (150) NOT NULL,
compania_integrantes INT NOT NULL,
compania_situacion SMALLINT DEFAULT 1
);


-- 3. TABLA CAPACITACIONES/ENTRENAMIENTOS
CREATE TABLE kvsc_capacitacion(
capacitacion_id SERIAL PRIMARY KEY,
capacitacion_nombre VARCHAR (200) NOT NULL,
capacitacion_descripcion LVARCHAR (1056) NOT NULL,
capacitacion_duracion_horas INT NOT NULL,
capacitacion_tipo VARCHAR (100) NOT NULL,
capacitacion_situacion SMALLINT DEFAULT 1
);


-- 4. TABLA HORARIOS DE ENTRENAMIENTO
CREATE TABLE kvsc_horario_entrenamiento(
horario_id SERIAL PRIMARY KEY,
horario_capacitacion_id INT NOT NULL,
horario_instructor_id INT NOT NULL,
horario_compania_id INT NOT NULL,
horario_fecha_inicio DATE NOT NULL,
horario_fecha_fin DATE NOT NULL,
horario_hora_inicio VARCHAR (10) NOT NULL,
horario_hora_fin VARCHAR (10) NOT NULL,
horario_ubicacion VARCHAR (250) NOT NULL,
horario_estado VARCHAR (50) DEFAULT 'PROGRAMADO',
horario_usuario_asigno INT NOT NULL,
horario_fecha_creacion DATE DEFAULT TODAY,
horario_observaciones LVARCHAR (1056),
horario_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (horario_capacitacion_id) REFERENCES kvsc_capacitacion(capacitacion_id),
FOREIGN KEY (horario_instructor_id) REFERENCES kvsc_instructor(instructor_id),
FOREIGN KEY (horario_compania_id) REFERENCES kvsc_compania(compania_id),
FOREIGN KEY (horario_usuario_asigno) REFERENCES kvsc_usuario(usuario_id)
);