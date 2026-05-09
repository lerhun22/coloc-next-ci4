Structure minimale de .env est 

###
CI_ENVIRONMENT=development

app.baseURL='http://localhost:8080/'

database.default.hostname=127.0.0.1 -> pas de localhost
database.default.database=coloc
database.default.username=root
database.default.password=root
database.default.DBDriver=MySQLi
database.default.DBPrefix=
database.default.port=8889 -> PORT MAMP SQL
###

NE PAS HESITER A REBOOTER MACHINE -> LANCER SERVICE MAMP -> LANCER %php spark server : http://localhost:8080/test-db

###

ETAPE 2 : 

Infrastructure COLOC minimale
Objectif :
layout principal
BaseController propre
ActiveCompetitionService
première config applicative
première page home COLOC

public/uploads/competitions/2020_N_293_00_0099