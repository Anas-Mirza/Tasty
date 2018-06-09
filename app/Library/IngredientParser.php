<?php

namespace App\Library;

class IngredientParser {

     //This Function Takes a Ingredient String and returns an Asssoc Array That may contain the keys:
	//quantity, unit, name, info
	//The Info field contians any addtional info contained within the ingredient string
public function parser_ingredient($IngredientString){
	
	$IngredientString = preg_replace("/ {2,}/", " ", $IngredientString);
    $string = " ".$IngredientString;
	$fractions = array(
		'1/2' => '½',
		'1/4' => '¼',
		'2/3' => '⅔',
		'3/4' => '¾',
	);
	$keys = array_keys($fractions);

for($i=0; $i < count($keys); ++$i){
	
	if(strpos($string,$fractions[$keys[$i]])){
		$arr = explode($fractions[$keys[$i]],$string);
		$arr[0] = trim($arr[0])." ".$keys[$i];
		$IngredientString = implode(" ",$arr);
	   }
}
	
	$IngredientData = array();
	if (preg_match("/[0-9][0-9\s?]+[0-9][\/][0-9]|[0-9\s?]+[0-9][\/][0-9]|[0-9][\/][0-9]|[0-9][0-9]|[0-9]/", $IngredientString)) { 
		preg_match( "/[0-9][0-9\s?]+[0-9][\/][0-9]|[0-9\s?]+[0-9][\/][0-9]|[0-9][\/][0-9]|[0-9][0-9]|[0-9]/", $IngredientString, $matches);
		$IngredientData['quantity'] = trim($matches[0]);
		$IngredientData['unit'] = " ";
	   
		//Check To See If We Have a Matching Unit in our $IngredientString
		$Units = $this->GetCookingUnits();
		
		//Check To See If We Can Find a Matching Unit
		foreach($Units as $Unit){
			if (preg_match("/\s+".$Unit."\s+/", $IngredientString)) {
				preg_match("/\s+".$Unit."\s+/", $IngredientString, $matches);
				$IngredientData['unit'] = trim($matches[0]);
				break;
			}
		}
		
		
		//Find The Name of The Item
		//Remove The Unit and Amount 
		$FixedString = $IngredientString;
		$FixedString = str_replace($IngredientData['unit'], "", $FixedString);
		$FixedString = str_replace($IngredientData['quantity'], "", $FixedString);
		
		$ArrayString = explode(",", $FixedString);
		if(count($ArrayString) > 1){
			$IngredientData['info'] = trim($ArrayString[1]);
		} 
		$IngredientData['name'] = trim($ArrayString[0]);
		
		// convert quantity to float
		$temp_string = $IngredientString;
		if (preg_match("/[0-9][0-9\s?]+[0-9][\/][0-9]|[0-9\s?]+[0-9][\/][0-9]/", $temp_string))
		{
		$temp_array = explode(" ",$IngredientData['quantity']);
		$IngredientData['quantity'] = (int)$temp_array[0] + $this->convert_into_decimal($temp_array[1]);
		}
		elseif (preg_match("/[0-9][\/][0-9]/",$temp_string))
		{
		$IngredientData['quantity'] = $this->convert_into_decimal($IngredientData['quantity']);
		}
		else
		{
			$var = $IngredientData['quantity'];
			$IngredientData['quantity'] = (float)$var;
		} //done 

		
	} else {
		//We Dont a have an ingrident quanity thus we could only have an ingredient and possibly an info value	
		//We Can spilt these two strings up by spilting on the ","
		$ArrayString = explode(",", $IngredientString);
		if(count($ArrayString) > 4){
			$IngredientData['info'] = $ArrayString[1];
		} 
		$IngredientData['name'] = $ArrayString[0];
	}
		$IngredientData['name'] = str_replace("finely chopped","",$IngredientData['name']);
		return $IngredientData;
	
}
//This function will return all of the useful cooking units
 private function GetCookingUnits(){
	$Units = array();
	
	$Units[] = "teaspoon"; 
	$Units[] = "t"; 
	$Units[] = "tsp."; 
	
	$Units[] = "ounce";
	$Units[] = "oz";
	$Units[] = "oz.";
	 
	
	
	$Units[] = "pounds"; 
	$Units[] = "lb"; 
	$Units[] = "lbs"; 
	$Units[] = "lb."; 
	$Units[] = "lbs."; 
	
	$Units[] = "tablespoon"; 
	$Units[] = "T"; 
	$Units[] = "tbl."; 
	$Units[] = "tbs."; 
	$Units[] = "tbsp."; 
	
	$Units[] = "fluid ounce"; 
	$Units[] = "fl oz";
	 
	$Units[] = "gill"; 
	
	$Units[] = "cup"; 
	$Units[] = "c"; 
	$Units[] = "c."; 
	
	$Units[] = "pint"; 
	$Units[] = "p"; 
	$Units[] = "pt"; 
	$Units[] = "fl pt"; 
	$Units[] = ""; 
	
	$Units[] = "quart"; 
	$Units[] = "q"; 
	$Units[] = "qt"; 
	$Units[] = "fl"; 
	$Units[] = "qt";
	 
	$Units[] = "gallon"; 
	$Units[] = "g"; 
	$Units[] = "gal"; 
	
	$Units[] = "ml"; 
	$Units[] = "milliliter"; 
	$Units[] = "millilitre"; 
	$Units[] = "cc"; 
	$Units[] = "mL"; 
	
	$Units[] = "l"; 
	$Units[] = "liter"; 
	$Units[] = "litre"; 
	$Units[] = "L"; 
	
	return $Units;	
 }

 public function parser_testrun(){
		
		//This program will run through some automated tests to check the ingredient-parsers correctness.
$IngredientStringArray = array();
$IngredientResultArray = array();
$IngredientStringArray[] = "1 c. white rice";
$IngredientResultArray[] = array("1","c.","white rice");
$IngredientStringArray[] = "extra-virgin olive oil";
$IngredientResultArray[] = array("extra-virgin olive oil");
$IngredientStringArray[] = "1 lb. shrimp, peeled and deveined";
$IngredientResultArray[] = array("1","lb.","shrimp","peeled and deveined");
$IngredientStringArray[] = "kosher salt";
$IngredientResultArray[] = array("kosher salt");
$IngredientStringArray[] = "Freshly ground black pepper";
$IngredientResultArray[] = array("Freshly ground black pepper");
$IngredientStringArray[] = "Salsa verde with tomatillo";
$IngredientResultArray[] = array("Salsa verde with tomatillo");
$IngredientStringArray[] = "2 1/4 c. Chopped cilantro";
$IngredientResultArray[] = array("1/4","c.","Chopped cilantro");
$IngredientStringArray[] = "Lime wedges";
$IngredientResultArray[] = array("Lime wedges");
$IngredientStringArray[] = "2 lb. chicken wings";
$IngredientResultArray[] = array("2","lb.","chicken wings");
$IngredientStringArray[] = "2 tbsp. olive oil";
$IngredientResultArray[] = array("2","tbsp.","olive oil");
$IngredientStringArray[] = "1 tsp. garlic powder";
$IngredientResultArray[] = array("1","tsp.","garlic powder");
$IngredientStringArray[] = "1 1/4 c. hot sauce (such as Franks)";
$IngredientResultArray[] = array("1 1/4","c.","hot sauce");
$IngredientStringArray[] = "1 tbsp. butter";
$IngredientResultArray[] = array("4","tbsp.","butter");
$IngredientStringArray[] = "2 tbsp. honey";
$IngredientResultArray[] = array("2","tbsp.","honey");
$IngredientStringArray[] = "Ranch dressing,for serving";
$IngredientResultArray[] = array("for serving", "Ranch dressing");
$IngredientStringArray[] = "Carrot sticks, for serving";
$IngredientResultArray[] = array("for serving", "Carrot sticks");
$IngredientStringArray[] = "celery sticks, for serving";
$IngredientResultArray[] = array("for serving", "celery sticks");
//Test Each Condition
$Count =0;
foreach($IngredientStringArray as $key => $IngredientTest){
	$ReturnArray = $this->ParserIndgredient($IngredientTest);
	
	if(array_diff($ReturnArray, $IngredientResultArray[$key])){
		echo "Failure On: ".$IngredientStringArray[$key]."<br>";
	}
	
	$Count++;
}
echo $Count." Successful Runs";

	    
  }

  public function convert_into_decimal($fraction)
  {
	  $numbers=explode("/",$fraction);
	  return round($numbers[0]/$numbers[1],6);
  }

}