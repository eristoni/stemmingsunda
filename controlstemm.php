<?php
require_once('preprocessing.php');
require_once('stemmsunda.php');


class ControlStemm
{
	function doPreprocessing($InputKata)
	{
		$preprocessing = new Preprocessing();
		$split = $preprocessing->stopword($preprocessing->tokenizing($preprocessing->casefolding($preprocessing->deliminating($InputKata))));

		$limit = count($split);

		$output[0] = $split;
		$output[1] = "";
		foreach ($split as $key) {
			$output[1] .= $key . "\n";
		}
		return $output;
	}

	function doStemming($InputKata)
	{
		
		$limit = count($InputKata);

		$output = "";
        for ($i=0; $i < $limit; $i++) 
        { 
        	if($InputKata[$i] != "") {
				$stemmer = new StemmSunda();
				$output .= $stemmer->stemm($InputKata[$i]);
				$output .= " ";
				$output .= "\n";
			}
        }
        return $output;
	}
}
?>