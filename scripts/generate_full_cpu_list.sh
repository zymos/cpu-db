#!/bin/bash

# Run as ./scripts/generate_full_cpu_list.sh


CATEGORIES="Manufacturer,Family,Part #,Alternative Label 1,Alternative Label 2,Alternative Label 3,Alternative Label 4,Chip Type"
CPU_FILE=cpu-db.csv

echo $CATEGORIES > $CPU_FILE
cat cpu-db.*.csv| grep -v "Manufacture" |sort >> $CPU_FILE
