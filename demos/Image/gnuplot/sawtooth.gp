set title  "Sawtooth wave"

set xrange [<from>:<to>]
set xlabel "t"

set yrange [-0.5:1.5]
set ytics  0,1
set ylabel "sawtooth(t)"

set grid
unset key

set style line 1 lt 1 lw 1 pt 3 lc rgb "black"

set terminal png nocrop enhanced font verdana 9 size 1000,200

plot "-" using 1:2 w l ls 1
