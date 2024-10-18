DROP TABLE IF EXISTS rol;
CREATE TABLE rol (
    id_rol text,
    nom_rol text
);

DROP TABLE IF EXISTS opcion_sistema;
CREATE TABLE opcion_sistema (
    id_opcion_sistema serial,
    cod_opcion_sistema text,
    nom_opcion_sistema text,
    otorgable integer
);

DROP TABLE IF EXISTS acceso_sistema;
CREATE TABLE acceso_sistema (
    id_acceso_sistema serial,
    id_rol text,
    cod_opcion_sistema text
);

DROP TABLE IF EXISTS acceso_sistema_usuario;
CREATE TABLE acceso_sistema_usuario (
    id_acceso_sistema_usuario serial,
    id_usuario integer,
    cod_opcion_sistema text
);

DROP TABLE IF EXISTS organizacion;
CREATE TABLE organizacion (
    id_organizacion serial,
    nom_organizacion text
);

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

DROP TABLE IF EXISTS parametro_sistema;
CREATE TABLE parametro_sistema (
    id_parametro_sistema serial,
    nom_parametro_sistema text,
    valor text
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

INSERT INTO rol (id_rol, nom_rol) VALUES
    ('usr','usuario'),
    ('sup','supervisor'),
    ('adm','administrador');

INSERT INTO opcion_sistema (cod_opcion_sistema, nom_opcion_sistema, otorgable) VALUES
    ('reportes.can_view','Ver reportes',null),
    ('reportes_usuario.can_view','Reportes de usuario',null),
    ('reportes_supervisor.can_view','Reportes de supervisor',null),
    ('reportes_administrador.can_view','Reportes de administrador',null),

    ('catalogos.can_view','Ver catalogos',null),
    ('organizacion.can_edit','Editar organizacion',null),
    ('parametro_sistema.can_edit','Editar parámetros del sistema',null),

    ('opcion_sistema.can_edit','Editar opciones del sistema',null),
    ('rol.can_edit','Editar roles',null),
    ('acceso_sistema.can_edit','Editar accesos del sistema',null),
    ('acceso_sistema_usuario.can_edit','Editar accesos del sistema por usuario',null),
    ('usuario.can_edit','Editar usuarios',null);

INSERT INTO acceso_sistema (id_rol, cod_opcion_sistema) VALUES
    ('adm','reportes.can_view'),
    ('adm','reportes_administrador.can_view'),
    ('adm','catalogos.can_view'),
    ('adm','opcion_sistema.can_edit'),
    ('adm','rol.can_edit'),
    ('adm','acceso_sistema.can_edit'),
    ('adm','acceso_sistema_usuario.can_edit'),
    ('adm','organizacion.can_edit'),
    ('adm','usuario.can_edit'),
    ('adm','parametro_sistema.can_edit'),

    ('sup','reportes.can_view'),
    ('sup','reportes_supervisor.can_view'),

    ('usr','reportes.can_view'),
    ('usr','reportes_usuario.can_view');


INSERT INTO organizacion (nom_organizacion) VALUES
    ('Lorem Ipsum');

INSERT INTO usuario (id_organizacion, id_rol, nom_usuario, usuario, password, activo) VALUES
    (1,'adm','Administrador','admon','hola',1),
    (1,'usr','Usuario1','usuario1','hola',1);

INSERT INTO parametro_sistema (nom_parametro_sistema, valor) VALUES
    ('nom_sitio_corto','RoboCtrl'),
    ('nom_sitio_largo','Panel de control de Robocop'),
    ('nom_org_sitio','OCP'),
    ('anio_org_sitio','2087'),
    ('tel_org_sitio','(555) 1123 4579'),
    ('correo_org_sitio','ed209@ocp.com'),
    ('logo_org_sitio','logo_ocp.png');
