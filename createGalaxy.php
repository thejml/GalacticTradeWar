<?php
$size=1000;
$connections=3;
$galaxy=array();

for ($x=0; $x<$size; $x++) {
	$y=floor(rand(0,$size));
	echo "Connecting: ".$x." to ".$y."\n";
	if (!is_array($galaxy[$x])) {
		echo $x." Not yet defined.\n";
		$galaxy[$x]=array('connections'=>array(), 'planet'=>'', 'debris'=>0, 'starbase'=>0);
		$galaxy[$x]['connections'][]=$y;
	} else {
		$galaxy[$x]['connections'][]=$y;
	}
	if (!is_array($galaxy[$y])) {
		echo $y." Not yet defined.\n";
		$galaxy[$y]=array('connections'=>array(), 'planet'=>'', 'debris'=>0, 'starbase'=>0);
		$galaxy[$y]['connections'][]=$x;
	} else {
		$galaxy[$y]['connections'][]=$x;
	}
}

for ($x=0; $x<$size; $x++) {
	echo $x." => ".json_encode($galaxy[$x])."\n";
}
//print_r($galaxy);
