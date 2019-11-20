<?php

    include_once dirname(__FILE__) . '/config.php';
    $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
    $sql = "

    -- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-11-2019 a las 16:57:48
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Creditos`
--

CREATE TABLE `Creditos` (
  `idCredito` int(6) NOT NULL,
  `idUsuario` int(6) NOT NULL,
  `fechaCredito` date NOT NULL,
  `valorCredito` double NOT NULL,
  `interesCredito` double NOT NULL,
  `saldoPendiente` double NOT NULL,
  `creditoPendiente` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cuentas`
--

CREATE TABLE `Cuentas` (
  `idCuenta` int(6) NOT NULL,
  `idUsuario` int(6) NOT NULL,
  `saldoCuenta` double NOT NULL,
  `cuotaManejo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tarjetas`
--

CREATE TABLE `Tarjetas` (
  `numeroTarjeta` int(6) NOT NULL,
  `idCuenta` int(6) NOT NULL,
  `cupoTajeta` double NOT NULL,
  `sobreCupo` double NOT NULL,
  `interes` double NOT NULL,
  `cuotaManejo` double NOT NULL,
  `tarjetaPendiente` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `idUsuario` int(6) NOT NULL,
  `nombreUsuario` varchar(60) NOT NULL,
  `contraUsuario` varchar(60) NOT NULL,
  `tipoUsuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Visitantes`
--

CREATE TABLE `Visitantes` (
  `idVisitante` int(6) NOT NULL,
  `correoVisitante` text NOT NULL,
  `cedulaVisitante` int(6) NOT NULL,
  `idCredito` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--


CREATE TABLE `Operaciones` (
  `idOperacion` int(6) NOT NULL,
  `idCuenta` int(6) NOT NULL,
  `idTarjeta` int(6) ,
  `monto` int(10),
  `descripcion` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Creditos`
--
ALTER TABLE `Creditos`
  ADD PRIMARY KEY (`idCredito`),
  ADD KEY `CreditoForKey` (`idUsuario`);

--
-- Indices de la tabla `Cuentas`
--
ALTER TABLE `Cuentas`
  ADD PRIMARY KEY (`idCuenta`),
  ADD KEY `CuentaForKey` (`idUsuario`);

--
-- Indices de la tabla `Tarjetas`
--
ALTER TABLE `Tarjetas`
  ADD PRIMARY KEY (`numeroTarjeta`),
  ADD KEY `TarjetaForKey` (`idCuenta`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `Visitantes`
--
ALTER TABLE `Visitantes`
  ADD PRIMARY KEY (`idVisitante`),
  ADD KEY `VisitanteForKey` (`idCredito`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Creditos`
--
ALTER TABLE `Creditos`
  MODIFY `idCredito` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Cuentas`
--
ALTER TABLE `Cuentas`
  MODIFY `idCuenta` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Tarjetas`
--
ALTER TABLE `Tarjetas`
  MODIFY `numeroTarjeta` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `idUsuario` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Visitantes`
--
ALTER TABLE `Visitantes`
  MODIFY `idVisitante` int(6) NOT NULL AUTO_INCREMENT;

--

--
-- AUTO_INCREMENT de la tabla `Creditos`
--
ALTER TABLE `Creditos`
  MODIFY `idCredito` int(6) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Creditos`
--
ALTER TABLE `Creditos`
  ADD CONSTRAINT `CreditoForKey` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Cuentas`
--
ALTER TABLE `Cuentas`
  ADD CONSTRAINT `CuentaForKey` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Tarjetas`
--
ALTER TABLE `Tarjetas`
  ADD CONSTRAINT `TarjetaForKey` FOREIGN KEY (`idCuenta`) REFERENCES `Cuentas` (`idCuenta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Visitantes`
--
ALTER TABLE `Visitantes`
  ADD CONSTRAINT `VisitanteForKey` FOREIGN KEY (`idCredito`) REFERENCES `Creditos` (`idCredito`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

    ";

    if ($con->multi_query($sql)) {
      echo "tablas creadas";
    }
    else{
      echo "Error al crear las tablas";
    }
    mysqli_close($con);

 ?>
