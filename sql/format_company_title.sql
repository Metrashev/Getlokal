CREATE FUNCTION `CAP_FIRST`(input VARCHAR(255))
RETURNS VARCHAR(255) DETERMINISTIC
BEGIN
DECLARE endstring INT;
DECLARE i INT;
DECLARE word VARCHAR(255);
DECLARE output VARCHAR(255);

SET input = CONCAT(LOWER(input)," ||");
SET i = 1;
SET endstring = 0;
SET word = "";
SET output = "";

WHILE (endstring = 0) DO
SET word = SUBSTRING_INDEX(SUBSTRING_INDEX(input, " ", i), " ", -1);
IF (word != "||") THEN

IF (word IN ("and","with","for","a",
"за", "от","на", "и", "до", "в", "във", "с", "със",
"of", "from", "to", "in", "or", "the", "at","on", "off",
"și","a","ai", "ale", "alor", "de", "dacă", "la", "de", "în", "si", "daca", "in"
)) THEN
SET word = LOWER(word);

ELSEIF  (UPPER(word) NOT IN (
"СОУ", "ЧСОУ", "ЧОУ", "ДКЦ", "БГ", "ОДЗ", "МБАЛ",  "МЦ", "ПГ", "ЦДГ", "МДКЦ",
"SOU", "OU", "BG","DKTS", "ODZ", "MBAL",  "MTZ", "PG", "TZDG", "MDKTZ",
"SRL", "SA", "SC", "ONG"
)) THEN
SET word = TRIM(CONCAT(UPPER(LEFT(word,1)),MID(word,2)));
END IF;
SET output = TRIM(CONCAT(output," ",word));
ELSE
SET endstring = 1;
END IF;
SET i = i + 1;
END WHILE;

RETURN output;
END
