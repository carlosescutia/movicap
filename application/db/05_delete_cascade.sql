/* Agregar primary key */
ALTER TABLE cuestionario
ADD PRIMARY KEY (id_cuestionario);

ALTER TABLE cuestionario_usuario
ADD PRIMARY KEY (id_cuestionario_usuario);

ALTER TABLE seccion
ADD PRIMARY KEY (id_seccion);

ALTER TABLE pregunta
ADD PRIMARY KEY (id_pregunta);

ALTER TABLE valor_posible
ADD PRIMARY KEY (id_valor_posible);

ALTER TABLE captura
ADD PRIMARY KEY (id_captura);

ALTER TABLE respuesta
ADD PRIMARY KEY (id_respuesta);


/* Agregar foreign keys */
ALTER TABLE seccion
ADD FOREIGN KEY (id_cuestionario) REFERENCES cuestionario(id_cuestionario)
ON DELETE CASCADE;

ALTER TABLE pregunta
ADD FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
ON DELETE CASCADE;

ALTER TABLE valor_posible
ADD FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta)
ON DELETE CASCADE;

ALTER TABLE captura
ADD FOREIGN KEY (id_cuestionario) REFERENCES cuestionario(id_cuestionario)
ON DELETE CASCADE;

ALTER TABLE respuesta
ADD FOREIGN KEY (id_captura) REFERENCES captura(id_captura)
ON DELETE CASCADE;
