<?php
/*
	File: shippingCalculator.php, contains the class ShippingCalculator, which contains all data necessary to calculate a shipping rate.
	Author: Faisal Mahmood
*/
class ShippingCalculator  {
	// Defaults for shipping
	var $weight = 1;
	var $sizeLength = 4;
	var $sizeWidth = 8;
	var $sizeHeight = 2;
	var $debug = false; // Change to true to see XML sent and recieved 
	
	
	// Config (you can either set these here or send them in a config array when creating an instance of the class)
	var $fromZip = 21250;
	var $toZip;

	
	/*
		Setup Class with Config Options
		Precondition: None
		Postcondition: All variables have been set.
	*/
	function ShippingCalculator($config) {
		
		$this->weight = $config[weight];
		$this->toZip = $config[toZip];		
	}
	
	/*
		Calculates the shipping rate for the package given the variable settings.
		Precondition: None
		Postcondition: The shipping rate has been returned.
		Return: The shipping rate for the package.
	*/
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
	
	

	/*
		Connects to USPS via url to send and receive shipping data.
		Precondition: requestURL has already been set up.
		Postcondition: USPS response has been returned as result.
		Return: USPS response to shipping-rate request.
	*/
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
