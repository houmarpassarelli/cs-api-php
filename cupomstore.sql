# Host: 127.0.0.1  (Version 5.5.5-10.1.22-MariaDB)
# Date: 2017-07-31 17:29:00
# Generator: MySQL-Front 5.3  (Build 5.33)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "cidade"
#

CREATE TABLE `cidade` (
  `id_cidade` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(300) DEFAULT NULL,
  `sigla` char(2) DEFAULT NULL,
  PRIMARY KEY (`id_cidade`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "cidade"
#

INSERT INTO `cidade` VALUES (1,'Cuiabá','MT'),(2,'Várzea Grande','MT');

#
# Structure for table "estabelecimento"
#

CREATE TABLE `estabelecimento` (
  `id_estabelecimento` int(11) NOT NULL AUTO_INCREMENT,
  `id_seguimento` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `titulo` varchar(600) DEFAULT NULL,
  `cnpj` varchar(100) DEFAULT NULL,
  `logo` varchar(1000) DEFAULT NULL,
  `descritivo` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id_estabelecimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "estabelecimento"
#


#
# Structure for table "estabelecimento_contato"
#

CREATE TABLE `estabelecimento_contato` (
  `id_estabelecimento_contato` int(11) NOT NULL AUTO_INCREMENT,
  `id_estabelecimento` int(11) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `valor` varchar(300) DEFAULT NULL,
  `primario` char(1) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_estabelecimento_contato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "estabelecimento_contato"
#


#
# Structure for table "estabelecimento_endereco"
#

CREATE TABLE `estabelecimento_endereco` (
  `id_estabelecimento_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `id_estabelecimento` int(11) DEFAULT NULL,
  `logradouro` varchar(300) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `bairro` varchar(300) DEFAULT NULL,
  `cep` int(11) DEFAULT NULL,
  `cidade_id` int(11) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `latitude` varchar(300) DEFAULT NULL,
  `longitude` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_estabelecimento_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "estabelecimento_endereco"
#


#
# Structure for table "oferta"
#

CREATE TABLE `oferta` (
  `id_oferta` int(11) NOT NULL AUTO_INCREMENT,
  `id_estabelecimento` int(11) DEFAULT NULL,
  `id_segmento` int(11) DEFAULT NULL,
  `id_pacote` int(11) DEFAULT NULL,
  `titulo` varchar(300) DEFAULT NULL,
  `img` varchar(10000) DEFAULT NULL,
  `descricao` varchar(600) DEFAULT NULL,
  `min_pessoas` int(11) DEFAULT NULL,
  `max_pessoas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "oferta"
#


#
# Structure for table "oferta_auth"
#

CREATE TABLE `oferta_auth` (
  `id_oferta_auth` int(11) NOT NULL AUTO_INCREMENT,
  `id_oferta` int(11) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `qr_code` varchar(10000) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `validade` datetime DEFAULT NULL,
  PRIMARY KEY (`id_oferta_auth`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "oferta_auth"
#


#
# Structure for table "oferta_galeria"
#

CREATE TABLE `oferta_galeria` (
  `id_oferta_galeria` int(11) NOT NULL AUTO_INCREMENT,
  `id_oferta` int(11) DEFAULT NULL,
  `img` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`id_oferta_galeria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "oferta_galeria"
#


#
# Structure for table "oferta_interacao"
#

CREATE TABLE `oferta_interacao` (
  `id_oferta_interacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `valor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_oferta_interacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "oferta_interacao"
#


#
# Structure for table "oferta_log"
#

CREATE TABLE `oferta_log` (
  `id_oferta_passport` int(11) NOT NULL AUTO_INCREMENT,
  `id_oferta` int(11) DEFAULT NULL,
  `data_autenticacao` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_estabelecimento` int(11) DEFAULT NULL,
  `id_oferta_auth` int(11) DEFAULT NULL,
  `latitude` varchar(300) DEFAULT NULL,
  `longitude` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_oferta_passport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "oferta_log"
#


#
# Structure for table "pacote"
#

CREATE TABLE `pacote` (
  `id_pacote` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(300) DEFAULT NULL,
  `qtd_ofertas` int(11) DEFAULT NULL,
  `valor` varchar(100) DEFAULT NULL,
  `validade` datetime DEFAULT NULL,
  `qtd_disponivel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pacote`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "pacote"
#

INSERT INTO `pacote` VALUES (1,'Pacote Premium',50,'50,00',NULL,100),(2,'Pacote Express',30,'30,00',NULL,100);

#
# Structure for table "segmento"
#

CREATE TABLE `segmento` (
  `id_segmento` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(300) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_segmento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "segmento"
#


#
# Structure for table "uri_hash"
#

CREATE TABLE `uri_hash` (
  `id_uri_hash` int(11) NOT NULL AUTO_INCREMENT,
  `uri_hash` varchar(300) NOT NULL,
  `uri_decode` varchar(300) NOT NULL,
  PRIMARY KEY (`id_uri_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "uri_hash"
#


#
# Structure for table "usuario"
#

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` bigint(20) DEFAULT NULL,
  `nome` varchar(300) DEFAULT NULL,
  `sobrenome` varchar(300) DEFAULT NULL,
  `avatar` varchar(10000) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `visivel` char(1) DEFAULT 'S',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "usuario"
#

INSERT INTO `usuario` VALUES (1,29524453849,'Houmar','Passarelli Rodrigues de Souza',NULL,NULL,'houmarpassarelli@gmail.com','S','2017-07-31 16:01:16',NULL),(2,146178343509,'Gleice','Marques',NULL,NULL,'gleicemarques@gmail.com','S','2017-07-31 16:01:51',NULL),(3,110369012661,'Raphael','Pires',NULL,NULL,'raphapires@gmail.com','S','2017-07-31 16:02:16',NULL);

#
# Structure for table "usuario_access"
#

CREATE TABLE `usuario_access` (
  `id_usuario_access` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `login` varchar(300) DEFAULT NULL,
  `senha` varchar(600) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ativo` char(1) DEFAULT 'S',
  PRIMARY KEY (`id_usuario_access`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "usuario_access"
#

INSERT INTO `usuario_access` VALUES (1,1,'1ae3f7b2f24e9b8a94df088f7adf59db','0603d8b209b6d340a05ec9b66aa57e10','2017-07-31 16:01:16',NULL,'S'),(2,2,'a2dd923d1c2fad467569cc9e79c273b4','e8d95a51f3af4a3b134bf6bb680a213a','2017-07-31 16:01:51',NULL,'S'),(3,3,'aa622d1829f3f68127c00e2df48320b5','e8d95a51f3af4a3b134bf6bb680a213a','2017-07-31 16:02:16',NULL,'S');

#
# Structure for table "usuario_auth"
#

CREATE TABLE `usuario_auth` (
  `id_usuario_auth` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_access` int(11) DEFAULT NULL,
  `hash` varchar(1000) DEFAULT NULL,
  `token` varchar(1000) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `validade_hash` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario_auth`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "usuario_auth"
#

INSERT INTO `usuario_auth` VALUES (1,1,NULL,'39f5881ef1e137564978f2762bb897a2','2017-07-31 16:01:16',NULL,NULL),(2,2,NULL,'dfba5f86d8a41726db692c389ed231da','2017-07-31 16:01:51',NULL,NULL),(3,3,NULL,'cf23ccf2560038882fe12e4f204059b5','2017-07-31 16:02:16',NULL,NULL);

#
# Structure for table "usuario_comentario"
#

CREATE TABLE `usuario_comentario` (
  `id_usuario_comentario` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_oferta` int(11) DEFAULT NULL,
  `alvo` varchar(200) DEFAULT NULL,
  `comentario` varchar(300) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `aprovado` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_usuario_comentario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "usuario_comentario"
#


#
# Structure for table "usuario_contato"
#

CREATE TABLE `usuario_contato` (
  `id_usuario_contato` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_contato` int(11) DEFAULT NULL,
  `pendente` char(1) DEFAULT 'S',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario_contato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "usuario_contato"
#

INSERT INTO `usuario_contato` VALUES (1,1,2,'S','2017-07-31 16:25:14',NULL),(2,1,3,'S','2017-07-31 16:25:54',NULL),(3,2,1,'S','2017-07-31 16:26:10',NULL),(4,2,3,'S','2017-07-31 16:26:19',NULL),(5,3,1,'S','2017-07-31 16:27:15',NULL),(6,3,2,'S','2017-07-31 16:27:19',NULL);

#
# Structure for table "usuario_endereco"
#

CREATE TABLE `usuario_endereco` (
  `id_usuario_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `logradouro` varchar(300) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `bairro` varchar(300) DEFAULT NULL,
  `cep` int(11) DEFAULT NULL,
  `cidade_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "usuario_endereco"
#


#
# Structure for table "usuario_log"
#

CREATE TABLE `usuario_log` (
  `id_usuario_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `data_acesso` datetime DEFAULT NULL,
  `ultima_acao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "usuario_log"
#

