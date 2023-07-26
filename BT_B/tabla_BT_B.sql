CREATE TABLE `BT_B` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unixtime` int(16) NOT NULL,
  `potencia_r` float NOT NULL,
  `potencia_s` float NOT NULL,
  `potencia_t` float NOT NULL,
  `potencia_III` float GENERATED ALWAYS AS (((`potencia_r` + `potencia_s`) + `potencia_t`)) VIRTUAL,
  `datetime` datetime GENERATED ALWAYS AS (FROM_UNIXTIME(`unixtime`)) VIRTUAL,
  `v_r` float NOT NULL,
  `v_s` float NOT NULL,
  `v_t` float NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
