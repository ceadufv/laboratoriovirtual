-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 14-Out-2019 às 15:58
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quimica`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cenario`
--

CREATE TABLE `cenario` (
  `id_cenario` int(11) NOT NULL,
  `data` longtext NOT NULL,
  `nome` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cenario`
--

INSERT INTO `cenario` (`id_cenario`, `data`, `nome`) VALUES
(1, '{\n  \"placeholder\": [\n    {\n      \"region\": \"bancada\",\n      \"x\": 240,\n      \"y\": 450\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 600,\n      \"y\": 450\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 960,\n      \"y\": 450\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 1320,\n      \"y\": 450\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 240,\n      \"y\": 740\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 600,\n      \"y\": 740\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 960,\n      \"y\": 740\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 1320,\n      \"y\": 740\n    },\n    {\n      \"region\": \"pia\",\n      \"x\": 2402,\n      \"y\": 508\n    },\n    {\n      \"region\": \"phmetro\",\n      \"x\": 1805,\n      \"y\": 650\n    },\n    {\n      \"region\": \"bancada1\",\n      \"x\": 1700,\n      \"y\": 318\n    },\n    {\n      \"region\": \"bancada1\",\n      \"x\": 1902,\n      \"y\": 318\n    },\n    {\n      \"region\": \"lenco\",\n      \"x\": 2350,\n      \"y\": 730\n    },\n    {\n      \"region\": \"phmetro_braco\",\n      \"x\": 2065,\n      \"y\": 537,\n      \"hidden\": true,\n      \"noInteraction\": true\n    },\n    {\n      \"region\": \"eletrodo\",\n      \"x\": 2100,\n      \"y\": 720,\n      \"hidden\": true\n    },\n    {\n      \"region\": \"phmetro_frente\",\n      \"x\": 2128,\n      \"y\": 572,\n      \"hidden\": true,\n      \"noInteraction\": true\n    },\n    {\n      \"region\": \"phmetro_bequer\",\n      \"x\": 2100,\n      \"y\": 760,\n      \"noInteraction\": true\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 1550,\n      \"y\": 740\n    }\n  ],\n  \"objetos\": [\n    {\n      \"concept\": \"pia\",\n      \"region\": \"pia\",\n      \"static\": true\n    },\n    {\n      \"concept\": \"pisseta\",\n      \"region\": \"bancada1\"\n    },\n    {\n      \"concept\": \"bequer_vazio\",\n      \"region\": \"bancada1\"\n    },\n    {\n      \"concept\": \"lenco\",\n      \"region\": \"lenco\"\n    },\n    {\n      \"concept\": \"phmetro\",\n      \"region\": \"phmetro\",\n      \"static\": true\n    },\n    {\n      \"concept\": \"phmetro_braco\",\n      \"region\": \"phmetro_braco\"\n    },\n    {\n      \"concept\": \"bequer_repouso\",\n      \"region\": \"phmetro_bequer\",\n      \"static\": true\n    },\n    {\n      \"concept\": \"eletrodo\",\n      \"region\": \"eletrodo\"\n    },\n    {\n      \"concept\": \"phmetro_frente\",\n      \"region\": \"phmetro_frente\",\n      \"static\": true\n    }\n  ]\n}', 'pHmetro'),
(2, '{\n  \"objetos\" : [\n   {\n     \"concept\" : \"pia\",\n      \"region\" : \"pia\",\n     \"static\" : true\n   },\n    {\n     \"concept\" : \"lenco\",\n      \"region\" : \"lenco\"\n    },\n    {\n     \"concept\" : \"espectrofotometro\",\n      \"region\" : \"instrumento\",\n     \"static\" : true\n   },\n    {\n     \"concept\" : \"pisseta\",\n      \"region\" : \"bancada1\"\n   },\n    {\n     \"concept\" : \"bequer_vazio\",\n     \"region\" : \"bancada1\"\n   },\n    {\n     \"concept\" : \"tampa_espectrofotometro\",\n      \"region\" : \"tampa_espectrofotometro\",\n     \"static\" : true,\n            \"alpha\":0.001\n   }\n ],\n  \"placeholder\" : [\n   {\n     \"region\" : \"bancada\",\n     \"x\" : 240,\n      \"y\" : 450\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 600,\n      \"y\" : 450\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 960,\n      \"y\" : 450\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 1320,\n     \"y\" : 450\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 240,\n      \"y\" : 740\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 600,\n      \"y\" : 740\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 960,\n      \"y\" : 740\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 1320,\n     \"y\" : 740\n   },\n    {\n     \"region\" : \"pia\",\n     \"x\" : 2402,\n     \"y\" : 508\n   },\n    {\n     \"region\" : \"instrumento\",\n     \"x\" : 1805,\n     \"y\" : 630\n   },\n    {\n     \"region\" : \"bancada1\",\n      \"x\" : 2250,\n     \"y\" : 740\n   },\n    {\n     \"region\" : \"bancada1\",\n      \"x\" : 2420,\n     \"y\" : 740\n   },\n    {\n     \"hidden\" : true,\n      \"noInteraction\" : true,\n     \"region\" : \"tampa_espectrofotometro\",\n     \"x\" : 1624,\n     \"y\" : 450\n   }\n ]\n}', 'Espectrofotômetro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplinas`
--

CREATE TABLE `disciplinas` (
  `id_disciplina` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `id_professor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo_pratica`
--

CREATE TABLE `modelo_pratica` (
  `id_modelo_pratica` int(11) NOT NULL,
  `id_cenario` int(11) NOT NULL,
  `nome_pratica` varchar(45) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `resumo` longtext,
  `id_disciplina` int(11) DEFAULT NULL,
  `disponivel` tinyint(4) DEFAULT NULL,
  `data` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo_pratica_arquivo`
--

CREATE TABLE `modelo_pratica_arquivo` (
  `cod_moprar` int(11) NOT NULL,
  `nome_moprar` varchar(300) DEFAULT NULL,
  `datai_moprar` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `scr_img_moprar` text,
  `type_img_moprar` varchar(300) DEFAULT NULL,
  `tipo_moprar` varchar(300) DEFAULT NULL COMMENT 'CADERNO / ROTEIRO',
  `fk_cod_mopr` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo_pratica_solucao`
--

CREATE TABLE `modelo_pratica_solucao` (
  `cod_moprsi` int(11) NOT NULL,
  `nome_moprsi` varchar(300) DEFAULT NULL,
  `desc_moprsi` varchar(300) DEFAULT NULL,
  `resp_moprsi` varchar(300) DEFAULT NULL,
  `data_criacao_moprsi` varchar(300) DEFAULT NULL,
  `composicoes` text,
  `fk_cod_mopr` int(11) DEFAULT NULL,
  `armario_moprsi` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo_pratica_u_usuario`
--

CREATE TABLE `modelo_pratica_u_usuario` (
  `cod_mopr_u_us` int(11) NOT NULL,
  `fk_id_modelo_pratica` int(11) DEFAULT NULL,
  `fk_id_usuario` int(11) DEFAULT NULL,
  `des_mopr_u_us` text,
  `dados_mopr_u_us` text COMMENT 'formato json',
  `datei_mopr_u_us` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='registros das praticas dos alunos';

-- --------------------------------------------------------

--
-- Estrutura da tabela `substancias`
--

CREATE TABLE `substancias` (
  `id_substancia` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `dados` varchar(45) NOT NULL,
  `id_usuario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `substancias`
--

INSERT INTO `substancias` (`id_substancia`, `nome`, `dados`, `id_usuario`) VALUES
(1, 'Ácido Forte', '[0, 1, 0, [-7]]', 'admin'),
(2, 'Base Forte', '[0, 1, -1, [14]]', 'admin'),
(3, 'Acetato', '[0, 1, -1, [4.76]]', 'admin'),
(4, 'Ácido Acético', '[0, 1, 0, [4.76]]', 'admin'),
(5, 'Prata I', '[1, 2, 1, [12, 12.01]]', 'admin'),
(6, 'Prata III', '[3, 5, 3, [5.02, 5.355, 5.69, 8.34, 10.91]]', 'admin'),
(7, 'Alanina 1-', '[1, 2, -1, [2.348, 9.867]]', 'admin'),
(8, 'Alanina-H', '[1, 2, 0, [2.348, 9.867]]', 'admin'),
(9, 'Alanina-H2', '[1, 2, 1, [2.348, 9.867]]', 'admin'),
(10, 'Amônia', '[1, 1, 0, [9.24]]', 'admin'),
(11, 'Amônio', '[1, 1, 1, [9.24]]', 'admin'),
(12, 'Anilina', '[1, 1, 0, [4.66]]', 'admin'),
(13, 'Anilínio', '[1, 1, 1, [4.66]]', 'admin'),
(14, 'Bário 2+', '[2, 2, 2, [13.36, 24.36]]', 'admin'),
(15, 'Benzoato', '[0, 1, -1, [4.202]]', 'admin'),
(16, 'Ácido Benzóico', '[0, 1, 0, [4.202]]', 'admin'),
(17, 'Bicarbonato', '[0, 2, -1, [6.37, 10.32]]', 'admin'),
(18, 'Borato', '[0, 1, -1, [9.234]]', 'admin'),
(19, 'Ácido Bórico', '[0, 1, 0, [9.234]]', 'admin'),
(20, 'Cálcio 2+', '[2, 2, 2, [12.67, 14]]', 'admin'),
(21, 'Cafeina', '[1, 1, 1, [0.5]]', 'admin'),
(22, 'Carbonato', '[0, 2, -2, [6.37, 10.32]]', 'admin'),
(23, 'Ácido Carbônico', '[0, 2, 0, [6.37, 10.32]]', 'admin'),
(24, 'Cádmio II', '[2, 4, 2, [10.08, 10.27, 12.95, 14.05]]', 'admin'),
(25, 'Citrato 3-', '[0, 3, -3, [3.128, 4.762, 6.396]]', 'admin'),
(26, 'Citrato-H', '[0, 3, -2, [3.128, 4.762, 6.396]]', 'admin'),
(27, 'Citrato-H2', '[0, 3, -1, [3.128, 4.762, 6.396]]', 'admin'),
(28, 'Ácido Cítrico', '[0, 3, 0, [3.128, 4.762, 6.396]]', 'admin'),
(29, 'Cromo III', '[3, 4, 3, [4, 5.62, 7.13, 11.02]]', 'admin'),
(30, 'Cromato-H2', '[0, 2, 0, [-0.2, 6.5]]', 'admin'),
(31, 'Cromato-H', '[0, 2, -1, [-0.2, 6.51]]', 'admin'),
(32, 'Cromato 2-', '[0, 2, -2, [-0.2, 6.51]]', 'admin'),
(33, 'Cobre II', '[2, 4, 2, [7, 7.32, 10.68, 12.5]]', 'admin'),
(34, 'Dietilamina', '[1, 1, 0, [11.11]]', 'admin'),
(35, 'Dietilamônio', '[1, 1, 1, [11.11]]', 'admin'),
(36, 'Dimetilamina', '[1, 1, 0, [10.72]]', 'admin'),
(37, 'Dimetilamônio', '[1, 1, 1, [10.72]]', 'admin'),
(38, 'EDTA 4-', '[0, 4, -4, [2, 2.678, 6.161, 10.26]]', 'admin'),
(39, 'EDTA 3-', '[0, 4, -3, [2, 2.678, 6.161, 10.26]]', 'admin'),
(40, 'EDTA 2-', '[0, 4, -2, [2, 2.678, 6.161, 10.26]]', 'admin'),
(41, 'EDTA 1-', '[0, 4, -1, [2, 2.678, 6.161, 10.26]]', 'admin'),
(42, 'EDTA', '[0, 4, 0, [2, 2.678, 6.161, 10.26]]', 'admin'),
(43, 'Etilamina', '[1, 1, 0, [10.75]]', 'admin'),
(44, 'Etilamônio', '[1, 1, 1, [10.75]]', 'admin'),
(45, 'Ferro III', '[3, 4, 3, [2.19, 3.48, 5.69, 9.6]]', 'admin'),
(46, 'Fenol', '[0, 1, 0, [9.89]]', 'admin'),
(47, 'Fenolato', '[0, 1, -1, [9.89]]', 'admin'),
(48, 'Fluoreto', '[0, 1, -1, [3.18]]', 'admin'),
(49, 'Ácido Fluorídrico', '[0, 1, 0, [3.18]]', 'admin'),
(50, 'Formiato', '[0, 1, -1, [3.760]]', 'admin'),
(51, 'Ácido Fórmico', '[0, 1, 0, [3.760]]', 'admin'),
(52, 'Hidrogenofosfato', '[0, 3, -2, [1.959, 7.125, 12.23]]', 'admin'),
(53, 'Fosfato', '[0, 3, -3, [1.959, 7.125, 12.23]]', 'admin'),
(54, 'Diidrogenofosfato', '[0, 3, -1, [1.959, 7.125, 12.23]]', 'admin'),
(55, 'Ácido Fosfórico', '[0, 3, 0, [1.959, 7.125, 12.23]]', 'admin'),
(56, 'Ftalato 2-', '[0, 2, -2, [2.950, 5.408]]', 'admin'),
(57, 'Ftalato 1-', '[0, 2, -1, [2.950, 5.408]]', 'admin'),
(58, 'Ácido Ftálico', '[0, 2, 0, [2.950, 5.408]]', 'admin'),
(59, 'Glicina', '[1, 2, -1, [2.350, 9.778]]', 'admin'),
(60, 'Glicina-H', '[1, 2, 0, [2.350, 9.778]]', 'admin'),
(61, 'Glicina-H2', '[1, 2, 1, [2.350, 9.778]]', 'admin'),
(62, 'Glifosfato', '[1, 4, -3, [1, 2.6, 5.6, 10.6]]', 'admin'),
(63, 'Glifosfato-H', '[1, 4, -2, [1, 2.6, 5.6, 10.6]]', 'admin'),
(64, 'Glifosfato-H2', '[1, 4, -1, [1, 2.6, 5.6, 10.6]]', 'admin'),
(65, 'Glifosfato-H3', '[1, 4, 0, [1, 2.6, 5.6, 10.6]]', 'admin'),
(66, 'Glifosfato-H4', '[1, 4, 1, [1, 2.6, 5.6, 10.6]]', 'admin'),
(67, 'Guanidina', '[1, 1, 0, [13.540]]', 'admin'),
(68, 'Guanidina-H', '[1, 1, 1, [13.540]]', 'admin'),
(69, 'Hidroxilamina', '[1, 1, 0, [6.04]]', 'admin'),
(70, 'Hidroxilamônio', '[1, 1, 1, [6.04]]', 'admin'),
(71, 'Histidina', '[2, 3, 0, [1.7, 6.02, 9.08]]', 'admin'),
(72, 'Histidina-H', '[2, 3, 1, [1.7, 6.02, 9.08]]', 'admin'),
(73, 'Histidina-H2', '[2, 3, 2, [1.7, 6.02, 9.08]]', 'admin'),
(74, 'Hássio 1-', '[0, 2, -1, [7, 15]]', 'admin'),
(75, 'Metilamina', '[1, 1, 0, [10.7]]', 'admin'),
(76, 'Metilamônio', '[1, 1, 1, [10.7]]', 'admin'),
(77, 'Magnésio 2+', '[2, 2, 2, [11.44, 16.86]]', 'admin'),
(78, 'Níquel II', '[2, 3, 2, [9.03, 10.42, 15.28]]', 'admin'),
(79, 'Nitrito', '[0, 1, -1, [3.292]]', 'admin'),
(80, 'Ácido Nitroso', '[0, 1, 0, [3.292]]', 'admin'),
(81, 'Hidrogenooxalato', '[0, 2, -1, [1.271, 4.266]]', 'admin'),
(82, 'Oxalato', '[0, 2, -2, [1.271, 4.266]]', 'admin'),
(83, 'Ácido Oxálico', '[0, 2, 0, [1.271, 4.266]]', 'admin'),
(84, 'Chumbo 2+', '[2, 4, 2, [7.71, 9.41, 10.94, 11.64]]', 'admin'),
(85, 'Piridina', '[1, 1, 0, [5.15]]', 'admin'),
(86, 'Piridínio', '[1, 1, 1, [5.15]]', 'admin'),
(87, 'Enxofre 2-', '[0, 2, -2, [7, 15]]', 'admin'),
(88, 'Salicilato', '[0, 1, -1, [2.98]]', 'admin'),
(89, 'Ácido Acetilsalicílico', '[0, 1, 0, [2.98]]', 'admin'),
(90, 'Hidrogenosulfato', '[0, 2, -1, [-3, 1.92082]]', 'admin'),
(91, 'Sulfato', '[0, 2, -2, [-3, 1.92082]]', 'admin'),
(92, 'Ácido Sulfídrico', '[0, 2, 0, [7, 15]]', 'admin'),
(93, 'Ácido Sulfúrico', '[0, 2, 0, [-3, 1.92082]]', 'admin'),
(94, 'Tartarato', '[0, 2, -2, [3.03, 4.54]]', 'admin'),
(95, 'Ácido Tartárico', '[0, 2, 0, [3.03, 4.54]]', 'admin'),
(96, 'Hidrogenotartarato', '[0, 2, -1, [3.03, 4.54]]', 'admin'),
(97, 'Trietilamina', '[1, 1, 0, [10.762]]', 'admin'),
(98, 'Trietilamônio', '[1, 1, 1, [10.762]]', 'admin'),
(99, 'Tris', '[1, 1, 0, [8.075]]', 'admin'),
(100, 'Tris-H', '[1, 1, 1, [8.075]]', 'admin'),
(101, 'Zinco II', '[2, 4, 2, [9.6, 7.1, 11.6, 10.48]]', 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `nome_tipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `nome_tipo`) VALUES
(1, 'Admin'),
(2, 'Professor'),
(3, 'Aluno');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_cadastrados`
--

CREATE TABLE `usuarios_cadastrados` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) NOT NULL,
  `id_tipo_usuario` int(11) DEFAULT NULL,
  `usuario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios_cadastrados`
--

INSERT INTO `usuarios_cadastrados` (`id_usuario`, `nome`, `email`, `senha`, `id_tipo_usuario`, `usuario`) VALUES
(1, 'ADMIN', 'admin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cenario`
--
ALTER TABLE `cenario`
  ADD PRIMARY KEY (`id_cenario`);

--
-- Indexes for table `disciplinas`
--
ALTER TABLE `disciplinas`
  ADD PRIMARY KEY (`id_disciplina`),
  ADD KEY `id_professor_idx` (`id_professor`);

--
-- Indexes for table `modelo_pratica`
--
ALTER TABLE `modelo_pratica`
  ADD PRIMARY KEY (`id_modelo_pratica`);

--
-- Indexes for table `modelo_pratica_arquivo`
--
ALTER TABLE `modelo_pratica_arquivo`
  ADD PRIMARY KEY (`cod_moprar`);

--
-- Indexes for table `modelo_pratica_solucao`
--
ALTER TABLE `modelo_pratica_solucao`
  ADD PRIMARY KEY (`cod_moprsi`);

--
-- Indexes for table `modelo_pratica_u_usuario`
--
ALTER TABLE `modelo_pratica_u_usuario`
  ADD PRIMARY KEY (`cod_mopr_u_us`);

--
-- Indexes for table `substancias`
--
ALTER TABLE `substancias`
  ADD PRIMARY KEY (`id_substancia`);

--
-- Indexes for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indexes for table `usuarios_cadastrados`
--
ALTER TABLE `usuarios_cadastrados`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cenario`
--
ALTER TABLE `cenario`
  MODIFY `id_cenario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `disciplinas`
--
ALTER TABLE `disciplinas`
  MODIFY `id_disciplina` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modelo_pratica`
--
ALTER TABLE `modelo_pratica`
  MODIFY `id_modelo_pratica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modelo_pratica_arquivo`
--
ALTER TABLE `modelo_pratica_arquivo`
  MODIFY `cod_moprar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modelo_pratica_solucao`
--
ALTER TABLE `modelo_pratica_solucao`
  MODIFY `cod_moprsi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modelo_pratica_u_usuario`
--
ALTER TABLE `modelo_pratica_u_usuario`
  MODIFY `cod_mopr_u_us` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `substancias`
--
ALTER TABLE `substancias`
  MODIFY `id_substancia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `usuarios_cadastrados`
--
ALTER TABLE `usuarios_cadastrados`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
