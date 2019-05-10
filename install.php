<?php
$action = @$_REQUEST['action'];
$error = @$_REQUEST['error'];
$path = pathinfo(__FILE__);
$config_file = $path['dirname']."/lab-config.php";
$error_message = @$_REQUEST['error_message'];
$error_title = @$_REQUEST['error_title'];
$debug = @$_REQUEST['debug'];
$database_created = 0;

// Estados
$estado = "index";

// Verifica o estado atual do processo de instalacao
switch ($action) {
  case "criar-config":
    $estado = "erro-criar-config";

    // Verifica se conseguira escrever no arquivo
    if (is_writeable($config_file)) {
      $estado = "criar-config";
    }

    $db_name = @$_REQUEST['db_name'];
    $db_user = @$_REQUEST['db_user'];
    $db_password = @$_REQUEST['db_password'];
    $db_host = @$_REQUEST['db_host'];

    $file = sprintf("<?php
/**
* As configurações básicas do Laboratorio Virtual de Quimica
*/

define('DB_NAME', '%s');
define('DB_USER', '%s');
define('DB_PASSWORD', '%s');
define('DB_HOST', '%s');
define('LAB_DEBUG', false);

/** Caminho absoluto para o diretório raiz */
if ( !defined('ABSPATH') ) define('ABSPATH', dirname(__FILE__) . '/');
",addslashes($db_name),addslashes($db_user),addslashes($db_password),addslashes($db_host));    
  break;
  case "instalar":
    $estado = "erro-criar-config";

    // Verifica se o arquivo lab-config.php existe e se possui as constantes esperadas
    if (file_exists($config_file)) {
      @include($config_file);

      if (
        defined('DB_NAME') &&
        defined('DB_USER') &&
        defined('DB_HOST')
      ) {
        $estado = "instalar";
      }
    }

    if ($estado != "instalar") {
      header("location:install.php?action=error&error_title=".urlencode("Erro no arquivo de configuração")."&error_message=".urlencode("Não foi possível criar o arquivo \"$config_file\"."));
      exit;
    }
  break;
}

// Executa a acao esperada para o estado atual
switch ($estado) {
  case "criar-config":
    // Cria o arquivo de configuracao
    $fp = @fopen($config_file,"w+");
    $fwrite = @fwrite($fp, $file);
    @fclose($fp);

    if ($fwrite) {
      header("location:install.php?action=instalar");
      exit;
    } else {
      header("location:install.php?action=error&error_title=".urlencode("Erro no arquivo de configuração")."&error_message=".urlencode("O arquivo \"$config_file\" não foi criado corretamente."));
      exit;
    }
  break;
  case "instalar":
    // Tenta se conectar
    include "banco/conexao.php";

    // Se a conexao falhar
    if (!$dbh) {
      header("location:install.php?action=error&error_title=".urlencode("Erro ao tentar acessar o banco de dados")."&error_message=".urlencode($error_message));
      exit;
    }

    $new_password = str_pad(rand(0,99999), 5, "0", STR_PAD_LEFT);

$sql = "
-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 18/12/2018 às 11:33
-- Versão do servidor: 5.7.24-0ubuntu0.18.04.1
-- Versão do PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lab_quimica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acao_pratica`
--

CREATE TABLE `acao_pratica` (
  `id_acao_pratica` int(11) NOT NULL,
  `data_acao` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_aluno` int(11) DEFAULT NULL,
  `id_pratica` int(11) DEFAULT NULL,
  `descricao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno_pratica`
--

CREATE TABLE `aluno_pratica` (
  `id_aluno` int(11) NOT NULL,
  `id_pratica` int(11) NOT NULL,
  `log_acoes` longtext,
  `nota` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_objetos`
--

CREATE TABLE `categorias_objetos` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `categorias_objetos`
--

INSERT INTO `categorias_objetos` (`id_categoria`, `nome_categoria`) VALUES
(1, 'bancadas'),
(2, 'solucoes'),
(3, 'instrumentos'),
(4, 'bequer'),
(5, 'balao_volumetrico'),
(6, 'pipeta_volumetrica'),
(7, 'pipetador'),
(8, 'micropipeta'),
(9, 'proveta'),
(10, 'cubeta'),
(11, 'espatula');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cenario`
--

CREATE TABLE `cenario` (
  `id_cenario` int(11) NOT NULL,
  `data` longtext NOT NULL,
  `nome` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `cenario`
--

INSERT INTO `cenario` (`id_cenario`, `data`, `nome`) VALUES
(1, '{\n  \"placeholder\": [\n    {\n      \"region\": \"bancada\",\n      \"x\": 240,\n      \"y\": 450\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 600,\n      \"y\": 450\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 960,\n      \"y\": 450\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 1320,\n      \"y\": 450\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 240,\n      \"y\": 740\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 600,\n      \"y\": 740\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 960,\n      \"y\": 740\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 1320,\n      \"y\": 740\n    },\n    {\n      \"region\": \"pia\",\n      \"x\": 2402,\n      \"y\": 508\n    },\n    {\n      \"region\": \"phmetro\",\n      \"x\": 1805,\n      \"y\": 650\n    },\n    {\n      \"region\": \"bancada1\",\n      \"x\": 1700,\n      \"y\": 318\n    },\n    {\n      \"region\": \"bancada1\",\n      \"x\": 1902,\n      \"y\": 318\n    },\n    {\n      \"region\": \"lenco\",\n      \"x\": 2350,\n      \"y\": 730\n    },\n    {\n      \"region\": \"phmetro_braco\",\n      \"x\": 2065,\n      \"y\": 537,\n      \"hidden\": true,\n      \"noInteraction\": true\n    },\n    {\n      \"region\": \"eletrodo\",\n      \"x\": 2100,\n      \"y\": 720,\n      \"hidden\": true\n    },\n    {\n      \"region\": \"phmetro_frente\",\n      \"x\": 2128,\n      \"y\": 572,\n      \"hidden\": true,\n      \"noInteraction\": true\n    },\n    {\n      \"region\": \"phmetro_bequer\",\n      \"x\": 2100,\n      \"y\": 760,\n      \"noInteraction\": true\n    },\n    {\n      \"region\": \"bancada\",\n      \"x\": 1550,\n      \"y\": 740\n    }\n  ],\n  \"objetos\": [\n    {\n      \"concept\": \"pia\",\n      \"region\": \"pia\",\n      \"static\": true\n    },\n    {\n      \"concept\": \"pisseta\",\n      \"region\": \"bancada1\"\n    },\n    {\n      \"concept\": \"bequer_vazio\",\n      \"region\": \"bancada1\"\n    },\n    {\n      \"concept\": \"lenco\",\n      \"region\": \"lenco\"\n    },\n    {\n      \"concept\": \"phmetro\",\n      \"region\": \"phmetro\",\n      \"static\": true\n    },\n    {\n      \"concept\": \"phmetro_braco\",\n      \"region\": \"phmetro_braco\"\n    },\n    {\n      \"concept\": \"bequer_repouso\",\n      \"region\": \"phmetro_bequer\",\n      \"static\": true\n    },\n    {\n      \"concept\": \"eletrodo\",\n      \"region\": \"eletrodo\"\n    },\n    {\n      \"concept\": \"phmetro_frente\",\n      \"region\": \"phmetro_frente\",\n      \"static\": true\n    }\n  ]\n}', 'pHmetro'),
(2, '{\n  \"objetos\" : [\n   {\n     \"concept\" : \"pia\",\n      \"region\" : \"pia\",\n     \"static\" : true\n   },\n    {\n     \"concept\" : \"lenco\",\n      \"region\" : \"lenco\"\n    },\n    {\n     \"concept\" : \"espectrofotometro\",\n      \"region\" : \"instrumento\",\n     \"static\" : true\n   },\n    {\n     \"concept\" : \"pisseta\",\n      \"region\" : \"bancada1\"\n   },\n    {\n     \"concept\" : \"bequer_vazio\",\n     \"region\" : \"bancada1\"\n   },\n    {\n     \"concept\" : \"tampa_espectrofotometro\",\n      \"region\" : \"tampa_espectrofotometro\",\n     \"static\" : true,\n            \"alpha\":0.001\n   }\n ],\n  \"placeholder\" : [\n   {\n     \"region\" : \"bancada\",\n     \"x\" : 240,\n      \"y\" : 450\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 600,\n      \"y\" : 450\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 960,\n      \"y\" : 450\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 1320,\n     \"y\" : 450\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 240,\n      \"y\" : 740\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 600,\n      \"y\" : 740\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 960,\n      \"y\" : 740\n   },\n    {\n     \"region\" : \"bancada\",\n     \"x\" : 1320,\n     \"y\" : 740\n   },\n    {\n     \"region\" : \"pia\",\n     \"x\" : 2402,\n     \"y\" : 508\n   },\n    {\n     \"region\" : \"instrumento\",\n     \"x\" : 1805,\n     \"y\" : 630\n   },\n    {\n     \"region\" : \"bancada1\",\n      \"x\" : 2250,\n     \"y\" : 740\n   },\n    {\n     \"region\" : \"bancada1\",\n      \"x\" : 2420,\n     \"y\" : 740\n   },\n    {\n     \"hidden\" : true,\n      \"noInteraction\" : true,\n     \"region\" : \"tampa_espectrofotometro\",\n     \"x\" : 1624,\n     \"y\" : 450\n   }\n ]\n}', 'Espectrofotômetro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplinas`
--

CREATE TABLE `disciplinas` (
  `id_disciplina` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `id_professor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelo_pratica`
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

--
-- Fazendo dump de dados para tabela `modelo_pratica`
--

INSERT INTO `modelo_pratica` (`id_modelo_pratica`, `id_cenario`, `nome_pratica`, `id_usuario`, `resumo`, `id_disciplina`, `disponivel`, `data`) VALUES
(1, 1, 'Determinação de pH com pHmetro', 14, 'Resumo', 18, 0, '{\"bequer\":[{\"id\":\"5\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"10\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"50\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"100\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"250\",\"disponivel\":true,\"qtd_maxima\":\"2\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"400\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"500\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"600\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"1000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"2000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"}],\"balao\":[{\"id\":\"5\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"10\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"25\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"50\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"100\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"200\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"250\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"500\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"1000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"2000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"}],\"pipeta\":[{\"id\":\"1\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"2\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"3\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"4\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"5\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"6\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"7\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"8\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"9\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"10\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"15\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"20\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"25\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"50\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"100\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"}],\"pipetador\":[{\"id\":\"Pera\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Pi-pump2\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Pi-pump5\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Pi-pump10\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Macropipetador\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Autom\\u00e1tico\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"}],\"micropipeta\":[{\"id\":\"10-100\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"animacao\":\"auto\"},{\"id\":\"50-200\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"animacao\":\"auto\"},{\"id\":\"100-1000\",\"disponivel\":true,\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"1000-5000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"animacao\":\"auto\"}],\"id_solucoes_pratica\":[]}'),
(2, 2, 'Espectrofotômetro', 14, 'Resumo da Prática', 16, 0, '{\"bequer\":[{\"id\":\"5\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"10\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"50\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"100\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"250\",\"disponivel\":true,\"qtd_maxima\":\"2\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"400\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"500\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"600\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"1000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"},{\"id\":\"2000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"volume_maximo\":\"80\",\"desvio_padrao\":\"10\",\"mistura\":\"false\"}],\"balao\":[{\"id\":\"5\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"10\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"25\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"50\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"100\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"200\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"250\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"500\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"1000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"2000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"}],\"pipeta\":[{\"id\":\"1\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"2\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"3\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"4\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"5\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"6\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"7\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"8\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"9\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"10\",\"disponivel\":true,\"qtd_maxima\":\"3\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"15\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"20\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"25\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"50\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"},{\"id\":\"100\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"ambientacao\":\"auto\",\"qtd_ambientes\":\"1\",\"agitacao\":\"auto\",\"faixa_aceitavel\":\"110\",\"desvio_padrao\":\"0.01\",\"mistura\":\"false\"}],\"pipetador\":[{\"id\":\"Pera\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Pi-pump2\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Pi-pump5\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Pi-pump10\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Macropipetador\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"Autom\\u00e1tico\",\"disponivel\":false,\"tamanho\":\"unico\",\"qtd_maxima\":\"1\",\"animacao\":\"auto\"}],\"micropipeta\":[{\"id\":\"10-100\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"animacao\":\"auto\"},{\"id\":\"50-200\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"animacao\":\"auto\"},{\"id\":\"100-1000\",\"disponivel\":true,\"qtd_maxima\":\"1\",\"animacao\":\"auto\"},{\"id\":\"1000-5000\",\"disponivel\":false,\"qtd_maxima\":\"0\",\"animacao\":\"auto\"}],\"id_solucoes_pratica\":[\"38\"]}');

-- --------------------------------------------------------

--
-- Estrutura para tabela `solucoes`
--

CREATE TABLE `solucoes` (
  `id_solucao` int(11) NOT NULL,
  `descricao` longtext,
  `tecnico` longtext,
  `nome` longtext,
  `intervalo` int(11) DEFAULT NULL,
  `concentracao` longtext,
  `nomes_composicao` longtext,
  `ids_composicao` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `solucoes` (`id_solucao`, `descricao`, `tecnico`, `nome`, `intervalo`, `concentracao`, `nomes_composicao`, `ids_composicao`) VALUES (1, 'Solução pH 12.96', 'admin', 'Solução pH 12.96', NULL, '0.01, 0.1, 0.01, 0.1', 'Amônia, Ácido forte, Acetato, Base Forte', '10, 1, 3, 2');
-- --------------------------------------------------------

--
-- Estrutura para tabela `solucoes_praticas`
--

CREATE TABLE `solucoes_praticas` (
  `idsolucao` int(11) NOT NULL,
  `idpratica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `substancias`
--

CREATE TABLE `substancias` (
  `id_substancia` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `dados` varchar(45) NOT NULL,
  `id_usuario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `substancias`
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
-- Estrutura para tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `nome_tipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `nome_tipo`) VALUES
(1, 'Admin'),
(2, 'Professor'),
(3, 'Aluno');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_cadastrados`
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
-- Fazendo dump de dados para tabela `usuarios_cadastrados`
--

INSERT INTO `usuarios_cadastrados` (`id_usuario`, `nome`, `email`, `senha`, `id_tipo_usuario`, `usuario`) VALUES
(1, 'Administrador', NULL, '".$lab->codificarSenha($new_password)."', 2, 'admin');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `acao_pratica`
--
ALTER TABLE `acao_pratica`
  ADD PRIMARY KEY (`id_acao_pratica`);

--
-- Índices de tabela `aluno_pratica`
--
ALTER TABLE `aluno_pratica`
  ADD PRIMARY KEY (`id_aluno`,`id_pratica`);

--
-- Índices de tabela `categorias_objetos`
--
ALTER TABLE `categorias_objetos`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `cenario`
--
ALTER TABLE `cenario`
  ADD PRIMARY KEY (`id_cenario`);

--
-- Índices de tabela `disciplinas`
--
ALTER TABLE `disciplinas`
  ADD PRIMARY KEY (`id_disciplina`),
  ADD KEY `id_professor_idx` (`id_professor`);

--
-- Índices de tabela `modelo_pratica`
--
ALTER TABLE `modelo_pratica`
  ADD PRIMARY KEY (`id_modelo_pratica`);

--
-- Índices de tabela `solucoes`
--
ALTER TABLE `solucoes`
  ADD PRIMARY KEY (`id_solucao`);

--
-- Índices de tabela `solucoes_praticas`
--
ALTER TABLE `solucoes_praticas`
  ADD PRIMARY KEY (`idsolucao`,`idpratica`);

--
-- Índices de tabela `substancias`
--
ALTER TABLE `substancias`
  ADD PRIMARY KEY (`id_substancia`);

--
-- Índices de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Índices de tabela `usuarios_cadastrados`
--
ALTER TABLE `usuarios_cadastrados`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `acao_pratica`
--
ALTER TABLE `acao_pratica`
  MODIFY `id_acao_pratica` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `cenario`
--
ALTER TABLE `cenario`
  MODIFY `id_cenario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `disciplinas`
--
ALTER TABLE `disciplinas`
  MODIFY `id_disciplina` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `modelo_pratica`
--
ALTER TABLE `modelo_pratica`
  MODIFY `id_modelo_pratica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `solucoes`
--
ALTER TABLE `solucoes`
  MODIFY `id_solucao` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `substancias`
--
ALTER TABLE `substancias`
  MODIFY `id_substancia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT de tabela `usuarios_cadastrados`
--
ALTER TABLE `usuarios_cadastrados`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
";
/*
INSERT INTO `solucoes` (`id_solucao`, `descricao`, `tecnico`, `nome`, `intervalo`, `concentracao`, `nomes_composicao`, `ids_composicao`) VALUES (NULL, 'Solução pH 12.96', 'admin', 'Solução pH 12.96', NULL, '0.01, 0.1, 0.01, 0.1', 'Amônia, Ácido forte, Acetato, Base Forte', '10, 1, 3, 2');
INSERT INTO `solucoes_praticas` (`idsolucao`, `idpratica`) VALUES ('1', '1'), ('1', '2');
*/

    if ($dbh) {
       try {
            $database_created = $dbh->exec($sql);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            header("location:install.php?action=error&error_title=".urlencode("Erro ao tentar escrever no banco de dados")."&error_message=".urlencode($error_message));
            exit;
        }
    }
  break;
}

echo $estado;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>NeoAlice</title>
  <!-- Arquivos externos -->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
  <!-- <link rel="stylesheet" href="frameworks/fontawesome/web-fonts-with-css/css/fontawesome-all.css"> -->
  <!-- Arquivos próprios -->
  <link rel="stylesheet" href="estilos/basicos.css">
  <link rel="stylesheet" href="estilos/style.css">

  <link rel="shortcut icon" type="image/png" href="imagens/favicon.png"/>

</head>

<body>

  <div class="section login">
    <div class="container">
      <div class="row d-flex justify-content-center align-items-center">

        <div class="caixinha interna">
          <h1><br/>Laboratório Virtual de Química</h1>
          <h2>Universidade Federal de Viçosa</h2>

          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
            <polygon points="0,0 0,100 100,100"/>
          </svg>
          <div class="content">
<?php
if ($error_message) {
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <?php echo "<strong>".$error_title.":</strong> ".$error_message; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}
?>
<?php



  if ($estado == "index"):
?>
            <!--  -->
            <form class="opcoeslogin" method="post" action="install.php?action=criar-config">

              <h3>Instalação do Banco de Dados</h3>
              <p>
              <small>O laboratório virtual precisa de um banco de dados MySQL para funcionar. Informe a seguir os dados para criação do banco</small>
              </p>

              <div class="">
                <div class="input-group input-group-sm margem-inferior-p1">
                  <div class="input-group-prepend icone-formulario-principal">
                    <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-server"></i></div>
                  </div>
                  <input type="text" name="db_host" class="form-control texto-icone" placeholder="Servidor">
                </div>
              </div>

              <div class="">
                <div class="input-group input-group-sm margem-inferior-p1">
                  <div class="input-group-prepend icone-formulario-principal">
                    <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-database"></i></div>
                  </div>
                  <input type="text" name="db_name" class="form-control texto-icone" placeholder="Nome do banco de dados">
                </div>
              </div>

              <div class="">
                <div class="input-group input-group-sm margem-inferior-p1">
                  <div class="input-group-prepend icone-formulario-principal">
                    <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-user-tag"></i></div>
                  </div>
                  <input type="text" name="db_user" class="form-control texto-icone" placeholder="Usuário" id="usuarioLogin">
                </div>
                <div class="input-group input-group-sm margem-inferior-p1">
                  <div class="input-group-prepend icone-formulario-principal">
                    <div class="input-group-text texto-icone icone-formulario-secundario"><i class="fas fa-key"></i></div>
                  </div>
                  <input type="password" name="db_password" class="form-control texto-icone" placeholder="Senha" id="senhaLogin">
                </div>
              </div>

              <button type="submit" class="btn btn-block">Instalar Laboratório</button>

              <div class="text-center texto-icone-p margem-superior-p1" id="logLogin">
                <p class="log-login"></p>                
              </div>
            </form>
<?php
endif;

//if ($estado == "criar-config"):
    if ($estado == "erro-criar-config") {
?>
<form class="opcoeslogin" method="post" action="install.php?action=instalar">
<div class="form-group">
  <strong></strong>
  <label for="">Não foi possível criar o arquivo "lab-config.php". Por gentileza, copie o conteudo abaixo e crie o arquivo  manualmente no seguinte caminho: <?php
    echo $config_file;
  ?></label>
  <textarea class="form-control" rows="7" style="font-family: courier; font-weight: normal"><?php echo $file; ?></textarea>

  <button type="submit" class="btn btn-block">Continuar instalando</button>
</div>
</form>
<?php
    }

    if ($estado == "instalar") {
?>
<form class="opcoeslogin" method="post" action="index.php">
  <div class="form-group">
<?php if ($database_created === 0): ?>
      <strong>Laboratório instalado com sucesso!</strong>
      Anote as credenciais abaixo. Você irá precisar delas para acessar o laboratório<br /><br />
      <div class="alert alert-success" role="alert">
        <strong>Usuário:</strong> admin<br />
        <strong>Senha:</strong> <?php echo $new_password; ?>
      </div>
      <button type="submit" class="btn btn-block">Acessar o laboratório</button>
<?php else: ?>    
      <strong>O banco de dados já existe!</strong>
      Já existe uma instalação do laboratório no banco de dados '<?php echo DB_NAME; ?>'. Clique em acessar o laboratório se quiser prosseguir utilizando a instalação atual.<br /><br />
      <button type="submit" class="btn btn-block">Acessar o laboratório</button>  
<?php endif; ?>  
  </div>
</form>
<?php      
    }
//endif;
?>
            <div class="logomarcas">
              <!--
              <h3>Realização:</h3>
              <div>

              </div>
            -->
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>

  <footer class="container-fluid footer" id="contato">
    <div class="row">
      <div class="col-md-5 m-3">
        <div class="address">
          <img class="icone img-responsive" src="imagens/endereco2.png">
          <div>
            <p>Prédio da CEAD, Avenida PH Rolfs s/n</p>
            <p>Campus Universitário, 36570-000, Viçosa/MG</p>
            <p>Telefones: (31) 3899 2858 | (31) 3899 3987</p>
            <p>E-mail: cead@ufv.br</p>
          </div>  
        </div>
      </div>
      <div class="col m-3">
        <div class="logos">
          <div class="parceiros">
            <div>
              <h3>Realização:</h3>
            </div>
            <div>
              <hr>
              <a href="http://www.ufv.br" target="blank"><img src="imagens/UFV.png"></a>              
              <a href="http://www.cead.ufv.br" target="blank"><img src="imagens/cead.png"></a>
              <a href="http://www.deq.ufv.br" target="blank"><img src="imagens/GPEQA.png"></a>
              <a href="http://www.capes.gov.br/uab" target="blank"><img src="imagens/uab2.png"></a>
              <a href="http://www.capes.gov.br/" target="blank"><img src="imagens/capes2.png"></a>
            </div>
          </div>
        </div>
      </div>
      <div class="w-100"></div>
      <div class="col copyright">
        <div class="float-left">
          <h4>©2019 - Todos os Direitos Reservados - Desenvolvido pela Cead</h4>
        </div>
        <div class="float-right creative">
          <img src="https://acervo.cead.ufv.br/wp-content/themes/acervo/img/creativecommons.png">
          <p><small>Exceto onde indicado de outra forma, todos os conteúdos disponibilizados nesta página são licenciados sob uma licença Creative Commons</small></p>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>