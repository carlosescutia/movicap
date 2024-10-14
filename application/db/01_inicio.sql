DROP TABLE IF EXISTS usuario;
CREATE TABLE usuario (
    id_usuario serial,
    id_organizacion integer,
    id_rol text,
    nom_usuario text,
    usuario text,
    password text,
    activo integer
);

DROP TABLE IF EXISTS rol;
CREATE TABLE rol (
    id_rol text,
    nombre text
);

DROP TABLE IF EXISTS opcion_sistema;
CREATE TABLE opcion_sistema (
    id_opcion_sistema serial,
    codigo text,
    nombre text,
    url text,
    es_menu integer
);

DROP TABLE IF EXISTS acceso_sistema;
CREATE TABLE acceso_sistema (
    id_acceso_sistema serial,
    id_rol text,
    codigo text
);

DROP TABLE IF EXISTS opcion_publica;
CREATE TABLE opcion_publica (
    id_opcion_publica serial,
    orden integer,
    nombre text,
    url text
);

DROP TABLE IF EXISTS parametro_sistema;
CREATE TABLE parametro_sistema (
    id_parametro_sistema serial,
    nombre text,
    valor text
);

DROP TABLE IF EXISTS organizacion;
CREATE TABLE organizacion (
    id_organizacion serial,
    nom_organizacion text
);

DROP TABLE IF EXISTS bitacora;
CREATE TABLE bitacora (
    id_evento serial,
    fecha date,
    hora time,
    origen text,
    usuario text,
    nom_usuario text,
    nom_organizacion text,
    accion text,
    entidad text,
    valor text
);

INSERT INTO acceso_sistema (id_rol, codigo) VALUES
    ('adm', 1),
    ('adm', 2),
    ('adm', 3),
    ('adm', 4),
    ('adm', 5),
    ('usr', 1),
    ('usr', 2),
    ('usr', 3),
    ('usr', 4),
    ('usr', 99);

INSERT INTO opcion_publica (orden, nombre, url) VALUES
    (1, 'Aviso de inicio', 'publico/#inicio'),
    (2, 'Participación', 'publico/#participacion'),
    (3, 'Op3', 'publico/#op3');

INSERT INTO opcion_sistema (codigo, nombre, url, es_menu) VALUES
    (1,'Inicio','admin',1),
    (4,'Reportes','reportes',1),
    (5,'Catalogos','catalogos',1),
    (99,'Edicion','',0);

INSERT INTO organizacion (nom_organizacion) VALUES
    ('Lorem Ipsum');

INSERT INTO parametro_sistema (nombre, valor) VALUES
    ('nom_sitio_corto','RoboCtrl'),
    ('nom_sitio_largo','Panel de control de Robocop'),
    ('nom_org_sitio','OCP'),
    ('anio_org_sitio','2087'),
    ('tel_org_sitio','(555) 1123 4579'),
    ('correo_org_sitio','ed209@ocp.com'),
    ('logo_org_sitio','logo_ocp.png');

INSERT INTO rol (id_rol, nombre) VALUES
    ('usr','usuario'),
    ('sup','supervisor'),
    ('adm','administrador');

INSERT INTO usuario (id_organizacion, id_rol, nom_usuario, usuario, password, activo) VALUES
    (1,'adm','Administrador','admon','hola',1),
    (1,'usr','Usuario1','usuario1','hola',1);
