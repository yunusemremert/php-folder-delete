<?php
function rrmdir($dir) {
	if (is_dir($dir)) {
	$objects = scandir($dir);
	foreach ($objects as $object) {
		if ($object != "." && $object != "..") {
			if (filetype($dir."/".$object) == "dir") 
				@rrmdir($dir."/".$object); 
				else @unlink   ($dir."/".$object);
		}
	}
	reset($objects);
	@rmdir($dir);
	}
}

$counter = 0;
$max     = 10; // Limit
$yol     = ""; // Dosya Yolu
$dizin   = opendir($yol);

while((($dosya = readdir($dizin)) !== false) && ($counter < $max)){
	if(!is_dir($dosya)){
		$zaman_bilgi = stat($yol.$dosya);

		//echo "-".$dosya."-".date("d.m.Y", $zaman_bilgi["mtime"])."<br>";
		if($dosya != "normal" && $dosya != ".ftpquota" && $dosya != "" && $dosya != ".htaccess"){
			//echo $counter."-".$dosya."<br>";

			$alt_dizin = opendir($yol.$dosya);

			while(($alt_dosya = readdir($alt_dizin)) !== false){
				if(!is_dir($alt_dosya)){
					$alt_zaman_bilgi = stat($yol.$dosya."/".$alt_dosya);
					$zaman_mktime    = mktime(0, 0, 0, date("m") - 3, date("d"), date("Y"));

					//echo date("d.m.Y", $zaman_mktime)."<br>";

					if($alt_zaman_bilgi["mtime"] <= $zaman_mktime){
						//echo "--->".$alt_dosya."****".date("d.m.Y", $alt_zaman_bilgi["mtime"])."<br>";

						rrmdir($yol.$dosya."/".$alt_dosya);
						@rmdir($yol.$dosya."/".$alt_dosya);
					}
				}
			}

			closedir($alt_dizin);
		}

		//echo "<hr>";
	}

	$counter++;
}

closedir($dizin);
?>