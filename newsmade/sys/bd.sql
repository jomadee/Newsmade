--
-- Newsmade | lliure 5
--
-- @Vers�o 4.0
-- @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
-- @Colaborador Rodrigo Dechen <mestri.rodrigo@gmail.com>
-- @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
-- @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
--

-- Copiando estrutura para tabela lliure_5.ll_newsmade_albuns
CREATE TABLE IF NOT EXISTS `ll_newsmade_albuns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `capa` int(11) DEFAULT NULL,
  `data` char(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_albuns_fotos
CREATE TABLE IF NOT EXISTS `ll_newsmade_albuns_fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album` int(11) NOT NULL,
  `foto` varchar(256) DEFAULT NULL,
  `descricao` varchar(256) DEFAULT NULL,
  `ordem` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `album` (`album`),
  KEY `album_2` (`album`),
  CONSTRAINT `ll_newsmade_albuns_fotos_ibfk_1` FOREIGN KEY (`album`) REFERENCES `ll_newsmade_albuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_albuns_videos
CREATE TABLE IF NOT EXISTS `ll_newsmade_albuns_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album` int(11) NOT NULL,
  `video` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album` (`album`),
  CONSTRAINT `ll_newsmade_albuns_videos_ibfk_1` FOREIGN KEY (`album`) REFERENCES `ll_newsmade_albuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_colunas
CREATE TABLE IF NOT EXISTS `ll_newsmade_colunas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_postagens
CREATE TABLE IF NOT EXISTS `ll_newsmade_postagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `coluna` int(11) DEFAULT NULL,
  `titulo` varchar(256) NOT NULL,
  `subtitulo` varchar(256) DEFAULT NULL,
  `introducao` text,
  `texto` text,
  `foto` int(11) DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `data_up` varchar(50) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `publicar` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Index 2` (`coluna`),
  CONSTRAINT `FK_ll_newsmade_postagens_ll_newsmade_categorias` FOREIGN KEY (`coluna`) REFERENCES `ll_newsmade_colunas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_postagens_albuns
CREATE TABLE IF NOT EXISTS `ll_newsmade_postagens_albuns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPostagem` int(11) NOT NULL,
  `idAlbum` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idPostagem` (`idPostagem`,`idAlbum`),
  KEY `idAlbum` (`idAlbum`),
  CONSTRAINT `ll_newsmade_postagens_albuns_ibfk_1` FOREIGN KEY (`idPostagem`) REFERENCES `ll_newsmade_postagens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ll_newsmade_postagens_albuns_ibfk_2` FOREIGN KEY (`idAlbum`) REFERENCES `ll_newsmade_albuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_postagens_comentarios
CREATE TABLE IF NOT EXISTS `ll_newsmade_postagens_comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postagem` int(11) NOT NULL,
  `titulo` varchar(256) NOT NULL,
  `comentario` text NOT NULL,
  `usuario` varchar(256) DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `status` enum('0','1') DEFAULT '0',
  `data` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `postagem` (`postagem`),
  CONSTRAINT `ll_newsmade_postagens_comentarios_ibfk_1` FOREIGN KEY (`postagem`) REFERENCES `ll_newsmade_postagens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_postagens_referencias
CREATE TABLE IF NOT EXISTS `ll_newsmade_postagens_referencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idNoticia` int(11) NOT NULL,
  `link` varchar(256) DEFAULT NULL,
  `titulo` varchar(256) DEFAULT NULL,
  `mostitulo` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idNoticia` (`idNoticia`),
  CONSTRAINT `ll_newsmade_postagens_referencias_ibfk_1` FOREIGN KEY (`idNoticia`) REFERENCES `ll_newsmade_albuns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_postagens_visualizacoes
CREATE TABLE IF NOT EXISTS `ll_newsmade_postagens_visualizacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postagem` int(11) NOT NULL,
  `data` bigint(14) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `postagem` (`postagem`),
  CONSTRAINT `ll_newsmade_postagens_visualizacoes_ibfk_1` FOREIGN KEY (`postagem`) REFERENCES `ll_newsmade_postagens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela lliure_5.ll_newsmade_topicos
CREATE TABLE IF NOT EXISTS `ll_newsmade_topicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topico` varchar(70) NOT NULL,
  `postagem` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `postagem` (`postagem`),
  CONSTRAINT `ll_newsmade_topicos_ibfk_1` FOREIGN KEY (`postagem`) REFERENCES `ll_newsmade_postagens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
