<?php

$times_arr = array();
for($i = 0; $i < 1000000; $i++) {
	$times = 0;
	$money = 1;
	while($money > 0) {
		$times++;
		if(mt_rand(1,100) == 51){
			$times_arr[$times]['failed']++;
			$money = 0;
		} else {
			$times_arr[$times]['passed']++;
		}
	}
}
ksort($times_arr);
$failed = 0;
foreach($times_arr as $timez => $timespf) {
	if(isset($timespf['failed']))	$failed += $timespf['failed'];
	echo $timez . ': ';
	$pct = $timespf['passed'] / ($timespf['passed'] + $failed);
	echo number_format($pct, 6) . "\n";
}
