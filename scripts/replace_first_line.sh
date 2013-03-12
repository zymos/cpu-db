#!/bin/bash

FIRST_LINE='Manufacturer,Family,Part #,Alternative Label 1,Alternative Label 2,Alternative Label 3,Alternative Label 4,Alternative Label 5,Alternative Label 6,Empty,Empty,Empty,Chip Type,Sub-Family,Model number,Core,Core designer,Microarchitecture,Threads,CPUID,Core Count,Pipeline,Multiprocessing,Empty,Empty,Empty,Architecture,Data Bus(ext),Address Bus,Bus comments,Frequency(ext),Frequency(internal min),Frequency(internal max/typ),Actual bus frequency,Effective bus frequency,Bus bandwidth,Clock multiplier,Core Stepping,Empty,Empty,Empty,Empty,L1 data cache,L1 data comments,L1 instruction cache,L1 instruction comments,L1 unified cache,L1 unified comments,L2 cache,L2 comments,L3 cache,L3 comments,Empty,ROM Internal,ROM Type,RAM internal,RAM max,RAM type,Virtual memory max,Empty,Empty,Empty,Empty,Package,Package Size,Package Weight,Socket,Transistor count,Process Size,Metal Layers,Metal Type,Process technology,Die size,Green,Empty,Empty,Empty,Vcc(core range),Vcc(core typical),Empty,Vcc(secondary),Vcc(tertiary),Empty,Vcc(I/O),I/O compatibility,Power Min,Power Typ,Power Max,Power Thermal Design,Temperature range,Temperature Grade,Low Power Features,Empty,Empty,Empty,Empty,Empty,Instruction set,Instruction set extensions,Additional instructions,Computer architecture,ISA,Empty,Empty,Empty,Empty,FPU,On-chip peripherals,Features,Empty,Empty,Production type,Clone,Release date,Initial price,Applications,Military Spec,Comments,Empty,Empty,Empty,Empty,Empty,Empty,Reference 1,Reference 2,Reference 3,Reference 4,Reference 5,Reference 6,Reference 7,Reference 8,Empty,Empty,Empty,Empty,Empty,Photo front filename 1,Photo front source 1,Photo front copyright 1,Photo front comment 1,Empty,Photo back filename 1,Photo back source 1,Photo back copyright 1,Photo back comment 1,Empty,Photo front filename 2,Photo front source 2,Photo front copyright 2,Photo front comment 2,Empty,Photo back filename 2,Photo back source 2,Photo back copyright 2,Photo back comment 2,Empty,Photo front filename 3,Photo front source 3,Photo front copyright 3,Photo front comment 3,Empty,Photo back filename 3,Photo back source 3,Photo back copyright 3,Photo back comment 3,Empty,Photo front filename 4,Photo front source 4,Photo front copyright 4,Photo front comment 4,Empty,Photo back filename 4,Photo back source 4,Photo back copyright 4,Photo back comment 4,Empty,Die photo 1,Die photo source 1,Die photo copyright 1,Die photo comment 1,Empty'

mkdir /tmp/bak/

for f in *.csv 
do 
	cp -f $f /tmp/bak
	tail -n +2 $f > /tmp/tmp.csv
	echo $FIRST_LINE > $f
	cat /tmp/tmp.csv >> $f
done
