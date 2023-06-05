<?php

$server = "localhost:3306";
$user = "root";
$pass = "573068";
$banco = "";

$conn = new PDO('mysql:host=' . $server . ';dbname=' . $banco, $user, $pass);

$createDB = $conn->query("CREATE DATABASE IF NOT EXISTS projeto_pi_2023");


$banco = "projeto_pi_2023";
$conn = new PDO('mysql:host=' . $server . ';dbname=' . $banco, $user, $pass);

$createTB = $conn->query("
CREATE TABLE IF NOT EXISTS foto_medicamento (
  id_foto int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome_foto varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tutorial_descarte (
  id_tutorial int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  video_tutorial varchar(255) NOT NULL,
  texto_tutorial varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS localizacao (
  id_localizacao int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  latitude_localizacao double NOT NULL,
  longitude_localizacao double NOT NULL
);

CREATE TABLE IF NOT EXISTS telefone_farmacia (
  id_telefone int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tel_farmacia varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS local_descarte (
  id_local_descarte int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  latitude_descarte double NOT NULL,
  longitude_descarte double NOT NULL
);

CREATE TABLE IF NOT EXISTS orientacoes_de_uso (
  id_orient_uso int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  serve varchar(255) NOT NULL,
  como_funciona varchar(255) NOT NULL,
  nao_usar varchar(255) NOT NULL,
  saber_antes varchar(255) NOT NULL,
  armazenar varchar(255) NOT NULL,
  como_usar varchar(255) NOT NULL,
  reacoes varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS forma_descarte (
  id_descarte int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  id_tutorial int(11) NOT NULL,
  id_localizacao_descarte int(11) NOT NULL,
  CONSTRAINT fk_FormaTuto FOREIGN KEY (id_tutorial) REFERENCES tutorial_descarte(id_tutorial),
  CONSTRAINT fk_FormaDesc FOREIGN KEY (id_localizacao_descarte) REFERENCES local_descarte(id_local_descarte)
);

CREATE TABLE IF NOT EXISTS usuario (
  id_conta_usuario int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome_usuario varchar(255) NOT NULL,
  email_usuario varchar(255) NOT NULL,
  senha_usuario varchar(255) NOT NULL,
  endereco_usuario varchar(255) NOT NULL
);

CREATE TABLE receituario (
  id_receituario int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  descricao varchar(255) NOT NULL
);

CREATE TABLE identificacao_med (
  id_identificacao int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  descricao varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tipo_med(
  id_tipo int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tipo varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS medicamento (
  id_med int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome_med varchar(255) NOT NULL,
  tipo_med int(11) NOT NULL,
  quant_med varchar(255) NOT NULL,
  class_med varchar(255) NOT NULL,
  valor_med decimal(10, 2) NOT NULL,
  id_foto_med int(11) NOT NULL,
  id_forma_descarte int(11) NOT NULL,
  id_orientacao_uso int(11) NOT NULL,
  id_receituario int(11) NOT NULL,
  id_identificacao int(11) NOT NULL,
  composicao varchar(255) NOT NULL,
  CONSTRAINT fk_MedFoto FOREIGN KEY (id_foto_med) REFERENCES foto_medicamento(id_foto),
  CONSTRAINT fk_MedDesc FOREIGN KEY (id_forma_descarte) REFERENCES forma_descarte(id_descarte),
  CONSTRAINT fk_MedOrien FOREIGN KEY (id_orientacao_uso) REFERENCES orientacoes_de_uso(id_orient_uso),
  CONSTRAINT fk_MedRec FOREIGN KEY (id_receituario) REFERENCES receituario (id_receituario),
  CONSTRAINT fk_MedIden FOREIGN KEY (id_identificacao) REFERENCES identificacao_med(id_identificacao),
  CONSTRAINT fk_MedTip FOREIGN KEY (tipo_med) REFERENCES tipo_med(id_tipo)
);

CREATE TABLE IF NOT EXISTS historico_pesquisa (
  id_pesquisa int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  id_conta_usuario int(11) NOT NULL,
  id_med int(11) NOT NULL,
  data_pesquisa date NOT NULL,
  horario_pesquisa time NOT NULL,
  CONSTRAINT fk_HistMed FOREIGN KEY (id_med) references medicamento(id_med),
  CONSTRAINT fk_HistUsu FOREIGN KEY (id_conta_usuario) REFERENCES usuario(id_conta_usuario)
);

CREATE TABLE situacao_farmacia (
  id_situacao int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  situacao varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS farmacia (
  id_farmacia int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome_farmacia varchar(255) NOT NULL,
  id_telefone int(11) NOT NULL,
  id_situacao int(11) NOT NULL,
  fechamento varchar(255) NOT NULL,
  endereco varchar(255) NOT NULL,
  CONSTRAINT fk_farmSitu FOREIGN KEY (id_situacao) REFERENCES situacao_farmacia(id_situacao),
  CONSTRAINT fk_farmTel FOREIGN KEY (id_telefone) REFERENCES telefone_farmacia(id_telefone)
);

CREATE TABLE IF NOT EXISTS estoque (
  id_estoque int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  qtd_med int(11) NOT NULL,
  id_med int(11) NOT NULL,
  id_farmacia int(11) NOT NULL,
  CONSTRAINT fk_EstoMed FOREIGN KEY (id_med) REFERENCES medicamento(id_med),
  CONSTRAINT fk_EstoFarm FOREIGN KEY (id_farmacia) REFERENCES farmacia(id_farmacia)
);

CREATE TABLE IF NOT EXISTS reserva_medicamento (
  id_reserva int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  horario_reserva time NOT NULL,
  horario_retirada time NOT NULL,
  id_conta_usuario int(11) NOT NULL,
  id_med int(11) NOT NULL,
  vl_pagar decimal(10,2) NOT NULL,
  status varchar(255) NOT NULL,
  nome_comp_usu varchar(255) NOT NULL,
  cpf_usu varchar(14) NOT NULL,
  CONSTRAINT fk_ReserUsu FOREIGN KEY (id_conta_usuario) REFERENCES usuario(id_conta_usuario),
  CONSTRAINT fk_ReserMed FOREIGN KEY (id_med) REFERENCES medicamento(id_med)
);

CREATE TABLE IF NOT EXISTS favoritos(
  id_favorito INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  id_farm INT NOT NULL,
  id_conta_usu INT NOT NULL,
  CONSTRAINT fk_FavFarm FOREIGN KEY (id_farm) REFERENCES farmacia(id_farmacia),
  CONSTRAINT fk_FavUsu FOREIGN KEY (id_conta_usu) REFERENCES usuario(id_conta_usuario)
);
        ");
