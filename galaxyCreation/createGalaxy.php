<?php

// Basic Settings:
$size=1000;
$connections=3;

// Autoloads:
require 'vendor/autoload.php'; // include Composer's autoloader

$client = new MongoDB\Client("mongodb://192.168.1.199:27017");
$collection = $client->gtw->sectors;

$galaxy=array();
$debrisTypes=array();


// Overall, 0 == No, 1 == Yes. Scales go from 0 (bad) => 5 (perfect)
// 'supportBase' => Can it support a permanent base? 0=No 1=Yes
// 'mining'
$planetTypes=array(
	'A'=>array('desc'=>'Small, young, and rocky.','supportBase'=>1,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'B'=>array('desc'=>'Small, young, and rocky.','supportBase'=>1,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>2,'minerals'=>array(''),'volcanic'=>4),
	'C'=>array('desc'=>'Small, young, and rocky.','supportBase'=>1,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>3,'minerals'=>array(''),'volcanic'=>3),
	'D'=>array('desc'=>'Asteroid or Small Moon','supportBase'=>1,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>2),
	'E'=>array('desc'=>'Proto-planet','supportBase'=>1,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'F'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'G'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'H'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'I'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'J'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'K'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'L'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'M'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'N'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'O'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'P'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'Q'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'R'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'S'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'T'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'U'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'V'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'W'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'X'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'Y'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5),
	'Z'=>array('desc'=>'Small, young, and rocky.','supportBase'=>0,'terraformable'=>0,'atmosphere'=>0,'mining'=>1,'stable'=>1,'minerals'=>array(''),'volcanic'=>5)
);

function choosePlanet($insist = false) {
	$y=floor(rand(0,360));
	if ($y%10==0) { 
		echo "Yay Planet! ".$y." ".($y%26)."\n";
		return $y%26;
	} else {
		echo "No Planet.";
		return 0;
	}
}

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
	$p=choosePlanet();
	$galaxy[$x]['planet']=($p!=0)?chr($p+64):0;
}

for ($x=0; $x<$size; $x++) {
	foreach ($galaxy[$x]['connections'] as $conn) {
		$sectorConnection = [
    			'id' => $x,
    			'body' => $conn
		];

        $result = $collection->insertOne( $sectorConnection );

        echo "Inserted with Object ID '{$result->getInsertedId()}'";

	}
	echo $x." => ".json_encode($galaxy[$x])."\n";
}


//print_r($galaxy);
