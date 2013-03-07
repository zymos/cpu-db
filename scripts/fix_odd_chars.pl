#!/bin/bash


Î¼ to µ

â€œ to "

â€ to "

â€“/-/

â€™ '

mkdir /tmp/bak/

for f in *.csv 
do 
	cp -f $f /tmp/bak
	sed -e 's//µ/g' -e 's//"/g' -e 's/’/\'/g' -e 's/‘/\'/g'  -e 's/”/"/g' -e 's/“/"/g' -e 's/–/-/g' -e 's/—/-/g' -e 's/-/-/g'



	echo $FIRST_LINE > $f
	cat /tmp/tmp.csv >> $f
done
