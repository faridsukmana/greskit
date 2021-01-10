<?php
	function get_info_network(){
		//--------mendapatkan informasi komputer melalui IP computer---//
		$hostname = gethostbyaddr(trim('192.168.1.17'));
		$ip = '192.168.1.17';

		SYSTEM(`ping $ip -n 1 && arp -a`);
		$output = `arp $ip -a`;
		$line = $output;
		echo '<br>'.$line.'<br/>';

		$pos = strpos("$line","$ip");

		$mac = str_replace("$ip","", $line);
		$mac1 = str_replace("dynamic","", $mac);
		$mac2 = trim(substr($mac1,86));

			if ($ip == $hostname)
				{
					$host = '';  
				}
			else
				{
					$host = $hostname;  
				}
		echo 'Host Name   :    ', $host;
		echo '<BR>';
		echo 'Mac Address :    ', $mac2;
	}
?>