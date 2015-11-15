<?php
class Preprocessing
{
	function casefolding($InputKata)
	{
		return strtolower($InputKata);
	}

	function tokenizing($InputKata)
	{
		return preg_split("/\ /", $InputKata);
	}

	function stopword($InputKata)
	{
		$listStopword= array("ka","di","ngan","mah","nu","ti");
		$Output = array();

		for($i=0; $i<count($InputKata); $i++)
		{
			$flag = true;

			foreach ($listStopword as $stopword)
			{
				if($InputKata[$i] == $stopword)
				{
					$flag = false;
				}
			}

			if($flag) $Output[] = $InputKata[$i];
		}
		return $Output;
	}
	function deliminating($InputKata)
	{
		$InputKata = preg_replace('/\é/','e', $InputKata);
		$InputKata = preg_replace('/\É/','e', $InputKata);
		$InputKata = preg_replace('/\-/',' ', $InputKata);
		$InputKata = preg_replace('/[^a-zA-Z ]/','',$InputKata);
		
		return $InputKata;
	}
}
?>