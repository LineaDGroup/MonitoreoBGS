/**********************************************
TABLA: bio_estadistica
***********************************************/

create table bio_estadistica (

    id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    id_bio_camara int(10),
    id_bio_ip varchar(20),
    fecha DATE,
    hora TIME,
    voltaje DECIMAL(6,2),
    consumo DECIMAL(6,2),
    created_at       	timestamp NULL,
    updated_at       	timestamp NULL,
    deleted_at          timestamp NULL,
    PRIMARY KEY(id)

);

/**********************************************
TABLA: bio_camara
***********************************************/

create table bio_camara (
    id int UNSIGNED AUTO_INCREMENT NOT NULL,
    id_mac varchar(17),
    nombre varchar(100),
    id_bio_centro int null,
    descripcion varchar(200),
    lunes_inicio TIME null,
    lunes_fin TIME null,
    martes_inicio TIME null,
    martes_fin TIME null,
    miercoles_inicio TIME null,
    miercoles_fin TIME null,
    jueves_inicio TIME null,
    jueves_fin TIME null,
    viernes_inicio TIME null,
    viernes_fin TIME null,
    sabado_inicio TIME null,
    sabado_fin TIME null,
    domingo_inicio TIME null,
    domingo_fin TIME null,
    id_bio_usuario int null,
    created_at       	timestamp NULL,
    updated_at       	timestamp NULL,
    deleted_at          timestamp NULL,
    PRIMARY KEY(id)
)

/**********************************************
TABLA: bio_usuario
***********************************************/

create table bio_usuario (
    id int UNSIGNED AUTO_INCREMENT NOT NULL,
    nombre varchar(100),
    Centro varchar(100),
    descripcion varchar(200),
    created_at       	timestamp NULL,
    updated_at       	timestamp NULL,
    deleted_at          timestamp NULL,
    PRIMARY KEY(id)
)

/**********************************************
TABLA: bio_centro
***********************************************/

create table bio_centro (
    id int UNSIGNED AUTO_INCREMENT NOT NULL,
    descripcion varchar(200),
    created_at       	timestamp NULL,
    updated_at       	timestamp NULL,
    deleted_at          timestamp NULL,
    PRIMARY KEY(id)
)
