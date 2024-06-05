-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/06/2024 às 13:44
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vacansee`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `BUSCA_PERFIL_GERENTE` (IN `id` INT)   BEGIN
SELECT nome
    FROM usuario AS u
        INNER JOIN hotel AS l
            ON l.id_hotel = (SELECT id_hotel FROM hotel WHERE id_usuario = id)
    WHERE u.id_usuario = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `BUSCA_PERFIL_HOSPEDE` (IN `id` INT)   BEGIN
SELECT nome, celular, email
    FROM usuario AS u
        INNER JOIN hospede AS l
            ON l.id_hospede = (SELECT id_hospede FROM hospede WHERE id_hospede = id)
    WHERE u.id_usuario = id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `cep` varchar(45) NOT NULL,
  `rua` varchar(45) NOT NULL,
  `numero` int(11) NOT NULL,
  `complemento` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `estado`, `cidade`, `bairro`, `cep`, `rua`, `numero`, `complemento`) VALUES
(1, 'PR', 'Curitiba', 'Barreirinha', '82700000', 'Rua Professor Guilherme Butler', 123, 'teste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `hospede`
--

CREATE TABLE `hospede` (
  `id_hospede` int(11) NOT NULL,
  `cpf` varchar(45) NOT NULL,
  `celular` varchar(45) NOT NULL,
  `data_nascimento` date NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `hospede`
--

INSERT INTO `hospede` (`id_hospede`, `cpf`, `celular`, `data_nascimento`, `id_usuario`) VALUES
(1, '09925804981', '99 99999-9999', '2001-01-06', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `hotel`
--

CREATE TABLE `hotel` (
  `id_hotel` int(11) NOT NULL,
  `cnpj` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `hotel`
--

INSERT INTO `hotel` (`id_hotel`, `cnpj`, `telefone`, `id_usuario`, `id_endereco`) VALUES
(16, '99.999.999/9999-99', '99 99999-9999', 19, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `quarto`
--

CREATE TABLE `quarto` (
  `id_quarto` int(11) NOT NULL,
  `andar` varchar(20) NOT NULL,
  `numero` int(11) NOT NULL,
  `tipo_cama` varchar(20) NOT NULL,
  `qtd_cama` int(11) NOT NULL,
  `qtd_banheiro` int(11) NOT NULL,
  `banheira` varchar(20) NOT NULL,
  `ar_condicionado` varchar(20) NOT NULL,
  `servico_quarto` varchar(20) NOT NULL,
  `cafe_manha` varchar(20) NOT NULL,
  `valor_dia` double NOT NULL,
  `flag_reservado` varchar(5) NOT NULL,
  `id_hotel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `quarto`
--

INSERT INTO `quarto` (`id_quarto`, `andar`, `numero`, `tipo_cama`, `qtd_cama`, `qtd_banheiro`, `banheira`, `ar_condicionado`, `servico_quarto`, `cafe_manha`, `valor_dia`, `flag_reservado`, `id_hotel`) VALUES
(8, '1', 1, '1', 1, 1, '1', '1', '1', '1', 1, '1', 16),
(9, '2', 2, '2', 2, 2, '2', '2', '2', '2', 2, 'S', 16);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `dia_entrada` date NOT NULL,
  `dia_saida` date NOT NULL,
  `valor_reserva` double NOT NULL,
  `id_hospede` int(11) NOT NULL,
  `id_quarto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `dia_entrada`, `dia_saida`, `valor_reserva`, `id_hospede`, `id_quarto`) VALUES
(1, '2024-06-06', '2024-06-09', 6, 1, 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `flag_bloqueado` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `email`, `usuario`, `senha`, `flag_bloqueado`) VALUES
(1, 'teste', 'teste@teste.com', 'teste', '202cb962ac59075b964b07152d234b70', 'N'),
(19, 'Matheus', 'teste@teste.com', 'teste1234', '202cb962ac59075b964b07152d234b70', 'N');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`);

--
-- Índices de tabela `hospede`
--
ALTER TABLE `hospede`
  ADD PRIMARY KEY (`id_hospede`),
  ADD KEY `fk_usuario_hospede` (`id_usuario`) USING BTREE;

--
-- Índices de tabela `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id_hotel`),
  ADD KEY `fk_usuario_hotel` (`id_usuario`),
  ADD KEY `fk_endereco_hotel` (`id_endereco`);

--
-- Índices de tabela `quarto`
--
ALTER TABLE `quarto`
  ADD PRIMARY KEY (`id_quarto`),
  ADD KEY `fk_hotel` (`id_hotel`);

--
-- Índices de tabela `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_reserva_hospede` (`id_hospede`),
  ADD KEY `fk_reserva_quarto` (`id_quarto`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `hospede`
--
ALTER TABLE `hospede`
  MODIFY `id_hospede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id_hotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `quarto`
--
ALTER TABLE `quarto`
  MODIFY `id_quarto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `hospede`
--
ALTER TABLE `hospede`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `fk_endereco_hotel` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id_endereco`),
  ADD CONSTRAINT `fk_usuario_hotel` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `quarto`
--
ALTER TABLE `quarto`
  ADD CONSTRAINT `fk_hotel` FOREIGN KEY (`id_hotel`) REFERENCES `hotel` (`id_hotel`);

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_reserva_hospede` FOREIGN KEY (`id_hospede`) REFERENCES `hospede` (`id_hospede`),
  ADD CONSTRAINT `fk_reserva_quarto` FOREIGN KEY (`id_quarto`) REFERENCES `quarto` (`id_quarto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
