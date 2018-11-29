<?php

echo $_header;

if(is_array($_content)){
	foreach ($_content as $c){
	echo $c;
	}
} else {
	echo $_content;
}

echo $_footer;

?>