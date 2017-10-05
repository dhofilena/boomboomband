#!/bin/bash
# Parameter:
# MidiFile
OLDIFS=$IFS
IFS=" "
while read BitRate SamplingRate
do
echo '.'
done < wav2mp3.cnf
IFS=$OLDIFS
#./bin/timidity --config-file=./share/timidity/timidity.cfg -Ow1s1 -o $1.wav $1
#./bin/timidity --config-file=./share/timidity/timidity.cfg -Ov1s1 -o $1.ogg $1
/usr/local/bin/fluidsynth -g $2 -F $1.mp3 /usr/share/sounds/sf2/FluidR3_GM.sf2 $1
oggenc -q 5 $1.mp3
./lame -b $BitRate --resample $SamplingRate $1.wav $1.mp3
