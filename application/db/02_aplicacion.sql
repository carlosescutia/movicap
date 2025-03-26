DROP TABLE IF EXISTS cuestionario;
CREATE TABLE cuestionario (
    id_cuestionario serial,
    id_usuario integer,
    nom_cuestionario text,
    fecha date,
    lugar text
);

DROP TABLE IF EXISTS cuestionario_usuario;
CREATE TABLE cuestionario_usuario (
    id_cuestionario_usuario serial,
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
    hora time,
    lat numeric (10,6),
    lon numeric (10,6),
    geom geometry(point, 4326)
);

DROP TABLE IF EXISTS respuesta;
CREATE TABLE respuesta (
    id_respuesta serial,
    id_captura integer,
    id_pregunta integer,
    valor text
);

CREATE OR REPLACE FUNCTION actualizacoords() RETURNS TRIGGER AS $$
BEGIN
   UPDATE captura SET geom = ST_SETSRID(ST_MakePoint(cast(lon as float), cast(lat as float)),4326);
   RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER cambio_coordenadas
AFTER INSERT OR UPDATE OF lat, lon ON captura
    FOR EACH ROW EXECUTE FUNCTION actualizacoords();

