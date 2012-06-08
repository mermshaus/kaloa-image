set term png
set output           # output to stdout

set   autoscale      # scale axes automatically
unset log            # remove any log-scaling
unset label          # remove any previous labels
set xtic auto        # set xtics automatically
set ytic auto        # set ytics automatically
set xr [0:7]
set yr [-1.5:1.5]
plot sin(x)
