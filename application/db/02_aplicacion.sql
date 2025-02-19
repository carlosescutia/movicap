DROP TABLE IF EXISTS cuestionario;
CREATE TABLE cuestionario (
    id_cuestionario serial,
    nom_cuestionario text,
    fecha date,
    lugar text
);

DROP TABLE IF EXISTS cuestionario_usuario;
CREATE TABLE cuestionario_usuario (
    id_cuestionario integer,
    id_usuario integer
);

DROP TABLE IF EXISTS seccion;
CREATE TABLE seccion (
    id_seccion serial,
    id_cuestionario integer,
    nom_seccion text,
    orden integer
);

DROP TABLE IF EXISTS pregunta;
CREATE TABLE pregunta (
    id_pregunta serial,
    id_seccion integer,
    cve_tipo_pregunta integer,
    texto text,
    orden integer
);

DROP TABLE IF EXISTS tipo_pregunta;
CREATE TABLE tipo_pregunta (
    cve_tipo_pregunta text,
    nom_tipo_pregunta text,
    orden integer
);

DROP TABLE IF EXISTS valor_posible;
CREATE TABLE valor_posible (
    id_valor_posible serial,
    id_pregunta integer,
    texto text,
    valor text,
    orden integer
);

DROP TABLE IF EXISTS captura;
CREATE TABLE captura (
    id_captura serial,
    id_cuestionario integer,
    id_usuario integer,
    fecha date,
    lat numeric (10,6),
    lon numeric (10,6)
);

DROP TABLE IF EXISTS respuesta;
CREATE TABLE respuesta (
    id_respuesta serial,
    id_captura integer,
    id_pregunta integer,
    valor text
);

