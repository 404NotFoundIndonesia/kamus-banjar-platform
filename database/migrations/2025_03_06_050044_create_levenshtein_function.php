<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS LEVENSHTEIN;');

        DB::unprepared('CREATE FUNCTION LEVENSHTEIN(s1 VARCHAR(255), s2 VARCHAR(255)) RETURNS INT DETERMINISTIC BEGIN
            DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
            DECLARE s1_char CHAR;
            DECLARE cv0, cv1 VARBINARY(256);
            
            SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
            
            IF s1 = s2 THEN
                RETURN 0;
            ELSEIF s1_len = 0 THEN
                RETURN s2_len;
            ELSEIF s2_len = 0 THEN
                RETURN s1_len;
            ELSE
                WHILE j <= s2_len DO
                    SET cv1 = CONCAT(cv1, UNHEX(HEX(j)));
                    SET j = j + 1;
                END WHILE;
                
                WHILE i <= s1_len DO
                    SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
                    
                    WHILE j <= s2_len DO
                        SET c = c + 1;
                        
                        IF s1_char = SUBSTRING(s2, j, 1) THEN
                            SET cost = 0;
                        ELSE
                            SET cost = 1;
                        END IF;
                        
                        SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
                        IF c > c_temp THEN SET c = c_temp; END IF;
                        
                        SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
                        IF c > c_temp THEN SET c = c_temp; END IF;
                        
                        SET cv0 = CONCAT(cv0, UNHEX(HEX(c)));
                        SET j = j + 1;
                    END WHILE;
                    
                    SET cv1 = cv0;
                    SET i = i + 1;
                END WHILE;
            END IF;
            
            RETURN c;
        END;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS LEVENSHTEIN;');
    }
};
