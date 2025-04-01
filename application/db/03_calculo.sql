insert into tipo_pregunta (cve_tipo_pregunta, nom_tipo_pregunta, orden) values ('calculo', 'Cálculo', 4);
alter table pregunta add column nom_pregunta text;
alter table pregunta add column expresion text;
update pregunta set nom_pregunta = lower(replace(left(texto, 20), ' ', '_')) ;
