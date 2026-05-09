

SELECT * FROM `competitions` WHERE id = 293
SELECT * FROM `photos` WHERE competitions_id = 293
SELECT * FROM `notes` WHERE competitions_id = 293
SELECT * FROM `participants` WHERE competitions_id = 293
SELECT * FROM `clubs` WHERE competitions_id = 293

mysqldump -u root -proot -P 8889 coloc competitions --where="id=293" --no-create-info > competitions.sql
mysqldump -u root -proot -P 8889 coloc photos --where="competitions_id=293" --no-create-info > photos.sql
mysqldump -u root -proot -P 8889 coloc participants --where="competitions_id=293" --no-create-info > participants.sql
mysqldump -u root -proot -P 8889 coloc clubs --where="competitions_id=293" --no-create-info > clubs.sql

/Applications/MAMP/Library/bin/mysqldump -u root -proot -P 8889 coloc competitions --where="id=293" --no-create-info > competitions.sql
/Applications/MAMP/Library/bin/mysqldump -u root -proot -P 8889 coloc photos --where="competitions_id=293" --no-create-info > photos.sql
/Applications/MAMP/Library/bin/mysqldump -u root -proot -P 8889 coloc participants --no-create-info > participants.sql
/Applications/MAMP/Library/bin/mysqldump -u root -proot -P 8889 coloc clubs --no-create-info > clubs.sql      
/Applications/MAMP/Library/bin/mysqldump \
-u root \
-proot \
-P 8889 \
coloc competition_meta \
--where="competition_id=293" \
--no-create-info \
--skip-comments \
--compact \
> competition_meta.sql
