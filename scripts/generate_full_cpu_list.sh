#!/bin/bash

# Run as ./scripts/generate_full_cpu_list.sh


CATEGORIES="Manufacturer,Family,Part #,Alternative Label 1,Alternative Label 2,Alternative Label 3,Alternative Label 4,Alternative Label 5,Empty,Empty,Empty,Chip Type,Sub-Family,Model number,Core,Core designer,Microarchitecture,Threads,CPUID,Core Count,Architecture,Data Bus (ext),Address Bus,Frequency Min,Frequency Max/Typ,Actual bus frequency,Effective bus frequency,Bus bandwidth,Clock multiplier,Core Stepping,Empty,Empty,Empty,Empty,L1 data cache,L1 data associativity,L1 instruction cache,L1 instruction associativity,L1 unified cache,L1 unified associativity,L2 cache,L2 associativity,L3 cache,L3 associativity,Boot ROM,ROM Internal,ROM Type,RAM internal,RAM max,RAM type,Virtual memory max,Empty,Empty,Empty,Empty,Package,Package Size,Package Weight,Socket,Transistor count,Process Size,Metal Layers,Metal Type,Process technology,Die Size,Empty,Empty,Empty,Empty,Vcc range,Vcc(typ),Empty,Vcc(secondary),Vcc(tertiary),Vcc(core),Vcc(I/O),Power Min,Power Typ,Power Max,Power Thermal Design,Temperature range,Low Power Features,Empty,Empty,Empty,Empty,Empty,Instruction set,Instruction set extensions,Additional instructions,Computer architecture,ISA,Empty,Empty,Empty,Empty,FPU,On-chip peripherals,Features,Empty,Empty,Empty,Empty,Release date,Initial price,Applications,Military Spec,Comments,Empty,Empty,Empty,Empty,Empty,Empty,Reference 1,Reference 2,Reference 3,Reference 4,Reference 5,Reference 6,Reference 7,Reference 8"
CPU_FILE=cpu-db.csv

echo $CATEGORIES > $CPU_FILE
cat cpu-db.*.csv| grep -v "Manufacture" |sort >> $CPU_FILE
