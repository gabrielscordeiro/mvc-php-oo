Projeto de um mini framework desenvolvido em PHP, Angular.js e Sass usando a estrutura MVC

Scripts pra criação das tabelas no postgre:

CREATE TABLE public.usuario
(
  codigo integer NOT NULL DEFAULT nextval('usuarios_codigo_seq'::regclass),
  usuario character varying(20),
  senha character varying(64),
  salt character varying(32),
  nome character varying(50),
  data_registro date,
  grupo integer,
  CONSTRAINT codigo_usuario PRIMARY KEY (codigo)
);

CREATE TABLE public.usuario_grupo
(
  codigo integer NOT NULL DEFAULT nextval('usuario_grupo_codigo_seq'::regclass),
  nome character varying(20),
  permissoes text,
  CONSTRAINT codigo_usuario_grupo PRIMARY KEY (codigo)
);

CREATE TABLE public.usuario_sessao
(
  codigo integer NOT NULL DEFAULT nextval('usuario_sessao_codigo_seq'::regclass),
  codigo_usuario integer,
  hash character varying(50),
  CONSTRAINT codigo_usuario_sessao PRIMARY KEY (codigo)
);

ALTER TABLE public.usuario_sessao
   ALTER COLUMN hash TYPE character varying(150);
