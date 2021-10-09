DROP PROCEDURE IF EXISTS `criarDicionarioDeTabela`;
CREATE PROCEDURE `criarDicionarioDeTabela`(IN banco VARCHAR(45), IN pr VARCHAR(15), IN tab VARCHAR(45), IN rotina INT)
BEGIN

  DECLARE pretab VARCHAR(45) DEFAULT CONCAT(pr,'_',tab);
  DECLARE col VARCHAR(45);
  DECLARE info TEXT;

  DECLARE done TINYINT DEFAULT 0;
  DECLARE ITENS CURSOR FOR SELECT COLUMN_NAME, COLUMN_COMMENT
                            FROM INFORMATION_SCHEMA.COLUMNS
                            WHERE TABLE_SCHEMA = banco COLLATE utf8_general_ci
                            AND TABLE_NAME = pretab COLLATE utf8_general_ci;

  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

  OPEN ITENS;
	  read_loop: LOOP FETCH FROM ITENS INTO col, info;
		  IF done THEN
		    LEAVE read_loop;
		  END IF;

      IF (SELECT COUNT(1) FROM tab_dicionario lib WHERE codrotina = rotina AND coluna = col COLLATE utf8_unicode_ci AND tabela = tab) = 0 THEN

        INSERT INTO tab_dicionario (tabela,codrotina,coluna,nome,descricao) VALUE (tab, rotina, col COLLATE utf8_unicode_ci, col COLLATE utf8_unicode_ci, info COLLATE utf8_unicode_ci);

      END IF;

	  END LOOP;
  CLOSE ITENS;
END;