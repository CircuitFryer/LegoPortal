<?php
class ShippingCalculator  {
	// Defaults
	var $weight = 1;
	var $sizeLength = 4;
	var $sizeWidth = 8;
	var $sizeHeight = 2;
	var $debug = false; // Change to true to see XML sent and recieved 
	
	
	// Config (you can either set these here or send them in a config array when creating an instance of the class)
	var $fromZip = 21250;
	var $toZip;

	
	// Setup Class with Config Options
	function ShippingCalculator($config) {
		
		$this->weight = $config[weight];
//		$this->sizeLength = $config[sizeLength];
//		$this->sizeWidth = $config[sizeWidth];
//		$this->sizeHeight = $config[sizeHeight];
		$this->toZip = $config[toZip];

		
	}
	
	// Calculate
	function calculate() {
		$xml = '
			<RateV4Request USERID="182APATU3767">
				<Package ID="1">
					<Service>Priority</Service>
					<ZipOrigination>'.$this->fromZip.'</ZipOrigination>
					<ZipDestination>'.$this->toZip.'</ZipDestination>
					<Pounds>'.$this->weight.'</Pounds>
					<Ounces>0</Ounces>
					<Container>VARIABLE</Container>
					<Size>REGULAR</Size>
					<Width>'.$this->sizeWidth.'</Width>
					<Length>'.$this->sizeLength.'</Length>
					<Height>'.$this->sizeHeight.'</Height>
					<Machinable>true</Machinable>
				</Package>    
			</RateV4Request>
		';

		
		$requestURL = "http://production.shippingapis.com/ShippingAPI.dll?API=RateV4&XML=" . rawurlencode($xml);
		

		// Curl
		$result = $this->connectToUSPS($requestURL);
		
		// Debug
		if($this->debug == true) {
			print "<xmp>".$requestURL."</xmp><br />";
			print "<xmp>".$result."</xmp><br />";	
		}
		
		// Match Rate(s)

		preg_match('/<Rate>(.+?)<\/Rate>/',$result,$rate);
			
		return $rate[1];
	}
	
	


	function connectToUSPS($requestURL) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $requestURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SLL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


		$result = curl_exec($ch);
		$error = curl_error($ch);

	 	curl_close($ch);

		if (empty($error)) {
			return $result;
		} 
		else {
			return false;
		}
	}	
	
}
?>
