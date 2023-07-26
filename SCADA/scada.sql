SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `scada` (
  `ID` int(11) NOT NULL,
  `item` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pot_III` float NOT NULL,
  `unixtime` bigint(20) NOT NULL,
  `datetime` datetime GENERATED ALWAYS AS (FROM_UNIXTIME(`unixtime`)) VIRTUAL,
  `v_r` int(11) NOT NULL,
  `v_s` int(11) NOT NULL,
  `v_t` int(11) NOT NULL,
  `energia_30` int(11) NOT NULL,
  `observaciones` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `scada`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `scada`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

INSERT INTO `scada` ( `item`, `pot_III`, `unixtime`, `observaciones`, `v_r`, `v_s`, `v_t`, `energia_30`) VALUES
( 'POT_MT'    , 0, 0, 'Edenor', 0, 0, 0, 0),
( 'POT_BT_A'  , 0, 0, 'Subestación transformadora A&C', 0, 0, 0, 0),
( 'POT_BT_B'  , 0, 0, 'Subestación transformadora EASA', 0, 0, 0, 0),
( 'POT_BT_A1' , 0, 0, 'maq de bolsas', 0, 0, 0, 0),
( 'POT_BT_A2' , 0, 0, 'M300-1; compresores; Hitachi; Iluminación', 0, 0, 0, 0),
( 'POT_BT_B1' , 0, 0, 'M1000 Beiren', 0, 0, 0, 0),
( 'POT_BT_B2' , 0, 0, 'Worldcolor', 0, 0, 0, 0),
( 'POT_BT_B3' , 0, 0, 'Carrier, compresores, iluminación', 0, 0, 0, 0);