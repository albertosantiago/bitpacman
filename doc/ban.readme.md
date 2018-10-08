El comando de banning se alimenta de dos ficheros csv:

Este que contiene el nombre de todos los csv de internet:

http://www.potaroo.net/bgp/iana/asn-ctl.txt .

Y de este, que contiene, buscando el de tu fecha las asignaciones de cidrs en los routers:
http://data.ris.ripe.net/rrc00/2003.04/bview.20030408.0000.gz

Formatear esta bbdd con el siguiente comando:

zcat bview.20030321.1600.gz | time ./zebra-dump-parser.pl >DUMP 2>DUMPERR
sort < DUMP | uniq | time ./aggregate-by-asn.pl > routes.tmp
mv routes.tmp routes

Despues cambiar el nombre de los ficheros a .csv.

FIN.
