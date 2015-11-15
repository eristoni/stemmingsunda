<?php
include('katasunda.php');

class StemmSunda
{	
	private $kataSunda;

	function __construct()
	{
		$this->kataSunda = new KataSunda();
	}

	function stemm($InputKata)
	{
		$this->kataSunda->kata=$InputKata;

		if($this->cekKamus($this->kataSunda->kata))
		{
        	$OutputKata = $this->kataSunda->kata;
        }
        else
        {    
			$KataProses=$this->akhiran1($this->kataSunda->kata); //proses menghilangkan akhiran ke 1
			$KataProses=$this->akhiran2($KataProses); // proses menghilangkan akhiran ke 2
			$KataProses=$this->awalan1($KataProses); // proses mengecek awalan ke 1
			
			if($KataProses['n'] == 2)
			{
				$OutputKata= $this->sisipan($KataProses ['KataTemp']);
			}
			else if($KataProses['n'] == 1)
			{
				$OutputKata = $KataProses['KataTemp'];
			}
			else if($KataProses['n'] == 0)
			{
				$KataProses = $this->awalan2($KataProses['KataTemp']);

				if($KataProses['n'] == 2)
				{
					$OutputKata= $this->sisipan($KataProses ['KataTemp']);
				}
				else if($KataProses['n'] == 1)
				{
					$OutputKata = $KataProses['KataTemp'];
				}
				else if($KataProses['n'] == 0)
				{
					$KataProses = $this->awalan3($KataProses['KataTemp']);

					if($KataProses['n'] == 2)
					{
						$OutputKata= $this->sisipan($KataProses5 ['KataTemp']);
					}
					else if($KataProses['n'] == 1)
					{
						$OutputKata = $KataProses['KataTemp'];
					}
					// else if($KataProses['n'] == 0)
					else
					{
						$KataProses = $this->awalan4($KataProses['KataTemp']);
						// $KataProses7 = $this->awalan4($KataProses);
						$KataProses = $this->sisipan($KataProses);
						$OutputKata = $KataProses;
					}
				}
			}
		}

		$this->kataSunda->kataDasar = $OutputKata;

		return $this->kataSunda->kataDasar;
	}

	function IsVocal($huruf)
	{
		if($huruf == "a" || $huruf == "i" || $huruf == "u" || $huruf == "e" || $huruf == "o")
		{
			return true;
		}		
		else
		{
			return false;
		}
	}

	function KonsonanPilihan($hurufk) //konsonan untuk aturan nga-
	{
		if($hurufk == "b" || $hurufk == "d" || $hurufk == "g" || $hurufk == "h" || $hurufk == "j" || $hurufk == "l" || $hurufk == "n" || $hurufk == "w" || $hurufk == "y" || $hurufk == "r")
		{
			return true;
		}		
		else
		{
			return false;
		}
	}

	function cekKamus($kata)
	{
		
		$sql = "SELECT * from katadasar where kata_dasar = '$kata' LIMIT 1";
		$result = mysql_query($sql) or die(mysql_error());
		
		if(mysql_num_rows($result)==1)
		{
			return true; // True jika ada
		}
		else
		{
			return false; // jika tidak ada FALSE
		}
	}

	function akhiran1($InputKata)
	{
		$KataTemp = $InputKata;
		// $kata_asal = $KataTemp;
		// if($this->cekKamus($KataTemp))
		// 	{
  //           	$KataTemp= $kata_asal;
  //           }
		if(substr($KataTemp,-4,4)=="ning")
		{
			$KataTemp=substr($KataTemp, 0,-4);
		}	
		else if((substr($KataTemp, -3,3)=="ing")  && (strlen($KataTemp)>5))
		{
			$KataTemp=substr($KataTemp, 0,-3);
		}

		else if ((substr($KataTemp, -3,3)=="ana") && ((substr($KataTemp, -6,3)=="eun") || (substr($KataTemp, -7,4=="keun")) || (substr($KataTemp, -5,2)=="an")))
		{
			if((substr($KataTemp, 0,3)=="dua") || (substr($KataTemp, 0,3)=="eta"))
			{
				$KataTemp=substr($KataTemp, 0,3);
			}
			else 
			{
				$KataTemp=substr($KataTemp, 0,-3);	
			}
		}
			
		else if ((substr($KataTemp, -2,2)=="na") && (strlen($KataTemp)>4))
		{
			
			$KataTemp=substr($KataTemp, 0,-2);
		}

		return $KataTemp;
	}

	function akhiran2($KataTemp)
	{
		if((substr($KataTemp, -3,3)=="eun") && (strlen($KataTemp)>6))
		{
			if (substr($KataTemp, -5,2)=="an")
			{
				$KataTemp=substr($KataTemp, 0,-5);
			}
			else
			{
				if (substr($KataTemp, -4,1)=="k")
				{
					if (substr($KataTemp, -6,2)=="na")
					{
						$KataTemp=substr($KataTemp, 0,-6);
					}
					else
					{
					$KataTemp=substr($KataTemp, 0,-4);	
					}
				}
				else 
				{
					$KataTemp=substr($KataTemp, 0,-3);
				}
			}
		}
		else if ((substr($KataTemp, -2,2)=="an") && (strlen($KataTemp)>4))
		{
			if (substr($KataTemp, -4,2)=="an")
				{
					$KataTemp=substr($KataTemp, 0,-4);
				}
			else
				{
					$KataTemp=substr($KataTemp, 0,-2);
				}
		}
		
		return $KataTemp;
	}

	function awalan1($KataTemp)
	{
		$hasil = array();
		$n=0;
		if((substr($KataTemp, 0,6)=="barang") && (strlen($KataTemp)>8))
		{
			$KataTemp=substr($KataTemp, 6);
			$n=1;
		}

		else if((substr($KataTemp, 0,5)=="nyang") && (strlen($KataTemp)>7))
		{
			if ($this->IsVocal(substr($KataTemp, 5,1))) 
			{
				$KataTemp=substr($KataTemp, 4);
				$n=1;
			}
			else
			{
				$KataTemp=substr($KataTemp, 5);	
				$n=1;
			}
		}

		else if((substr($KataTemp, 0,5)=="silih") && (strlen($KataTemp)>7))
		{
			$KataTemp=substr($KataTemp, 5);
			$n=1;
		}

		else if((substr($KataTemp, 0,4)=="pang") && (strlen($KataTemp)>6))
		{
			$KataTemp=substr($KataTemp, 4);
			$n=0;
		}

		else if((substr($KataTemp, 0,4)=="pada") && (strlen($KataTemp)>6) && ($KataTemp!="padaringan")) 
		{
			$KataTemp=substr($KataTemp, 4);
			$n=0;
		}

		else if((substr($KataTemp, 0,4)=="para") && (strlen($KataTemp)>6)) 
		{
			$KataTemp=substr($KataTemp, 4);
			$n=1;
		}

		else if((substr($KataTemp,0,3)=="per") && (strlen($KataTemp)>5)) 
		{
			$KataTemp=substr($KataTemp, 3);
			$n=1;
		}

		else if((substr($KataTemp,0,2)=="ba")|| (substr($KataTemp,0,2)=="si") || (substr($KataTemp,0,2)=="pa"))
		{
			$kata_asal = $KataTemp;
			$KataTemp=substr($KataTemp, 2);
			$n=1;

			if(!$this->cekKamus($KataTemp))
			{
	            $KataTemp= $kata_asal;
	            $n=0;
	        }
		}
		else if((strlen($KataTemp)>4) && (substr($KataTemp,0,2)=="ti") && (substr($KataTemp, 2,2)!= "ng")) 
		{
			$KataTemp=substr($KataTemp, 2);
			$n=2;	
		}
		else if((strlen($KataTemp)>4) && (substr($KataTemp,0,2)=="mi"))
		{
			$KataTemp=substr($KataTemp, 2);
			$n=0;	
		}

		$hasil['KataTemp'] = $KataTemp;
		$hasil['n'] = $n;
		return $hasil;
	}


	function awalan2($KataTemp)
	{
		$hasil = array();
		$n=0;
		if((substr($KataTemp, 0,2)=="di") && (strlen($KataTemp)>4))
		{
			$KataTemp=substr($KataTemp, 2);
			$n=0;
		}
		else if((substr($KataTemp, 0,4)=="ting") && (strlen($KataTemp)>6))
		{
			$KataTemp=substr($KataTemp, 4);
			$n=2;
		}
		else if((substr($KataTemp, 0,2)=="ka"))
		{
			$kata_asal = $KataTemp;
			$KataTemp=substr($KataTemp, 2);
			$n=1;

			if(!$this->cekKamus($KataTemp))
			{
	            $KataTemp= $kata_asal;
	            $n=0;
	        }
		}

		$hasil['KataTemp'] = $KataTemp;
		$hasil['n'] = $n;
		return $hasil;
	}

	function awalan3($KataTemp)
	{
		$hasil = array();
		$n=0;
		if((substr($KataTemp, 0,4)=="sang") && (strlen($KataTemp)>6) )
		{
			$KataTemp=substr($KataTemp, 4);
			$n=1;
		}
		else if((substr($KataTemp, 0,4)=="pika") && (strlen($KataTemp)>6))
		{
			$KataTemp=substr($KataTemp, 4);
			$n=0;
		}
		else if((substr($KataTemp, 0,2)=="sa") || (substr($KataTemp,0,2)=="pi"))
		{
			$kata_asal = $KataTemp;
			$KataTemp=substr($KataTemp, 2);
			$n=1;

			if(!$this->cekKamus($KataTemp))
			{
	            $KataTemp= $kata_asal;
	            $n=0;
	        }
		}
		else if((substr($KataTemp, 0,4)=="pang") && (strlen($KataTemp)>6))
		{
			$KataTemp=substr($KataTemp, 4);
			$n=0;
		}

		$hasil['KataTemp'] = $KataTemp;
		$hasil['n'] = $n;
		return $hasil;
	}

	function awalan4($KataTemp)
	{
		if((substr($KataTemp, 0,2)=="ng")) //kayaknya perlu ngecek database terus gabung dengan sisipan
		{
			
			if((substr($KataTemp, 2,1)=="a") && ($this->KonsonanPilihan(substr($KataTemp, 3,1)) ))
			{
				if ((strlen($KataTemp)>6) && (substr($KataTemp, 4,2)=="ar") || (substr($KataTemp, 4,2)=="al") )
				{
					$KataTemp= (substr_replace($KataTemp,"",0,3));	
				}
				else
				{
					$kata_asal=$KataTemp;
					$KataTemp= (substr_replace($KataTemp,"",0,3));
					if(!$this->cekKamus($KataTemp))
						{
			            	$KataTemp= $kata_asal;
			            	$kata_asal=$KataTemp;
							$KataTemp= (substr_replace($KataTemp,"",0,2));
							if(!$this->cekKamus($KataTemp))
								{
					            	$KataTemp= $kata_asal;
					            }
			            }
				}
			}
			
			else if (($this->IsVocal(substr($KataTemp, 2,1))))
			{
				$kata_asal=$KataTemp;
				$KataTemp= (substr_replace($KataTemp,"k",0,2));	
				if(!$this->cekKamus($KataTemp))
				{
					$KataTemp2= $kata_asal;
					$KataTemp= (substr_replace($KataTemp2,"",0,2));
					if(!$this->cekKamus($KataTemp))
					{
		            	$KataTemp= $kata_asal;
		            }
				}
			}
		}
		else if(substr($KataTemp, 0,2)=="ny") 
		{
			$kata_asal=$KataTemp; 
			if($this->cekKamus($KataTemp)) 
				{
					$KataTemp=$KataTemp;
				}	

			else if ((substr($KataTemp, 2,2)=="ar") || (substr($KataTemp, 2,2)=="al"))
			{
				$KataTemp= (substr_replace($KataTemp,"",2,2));
				if($this->cekKamus($KataTemp)) 
				{
					$KataTemp=$KataTemp;
				}
			}
			
			else
			{
				$KataTemp= (substr_replace($KataTemp,"c",0,2));
				$KataTemp1= $this->sisipan($KataTemp);
				if(!$this->cekKamus($KataTemp1))
				{
		            $KataTemp1= $kata_asal;
		            $KataTemp= (substr_replace($KataTemp1,"s",0,2));
		            $KataTemp1= $this->sisipan($KataTemp);
		            $KataTemp=$KataTemp1;
		            if(!$this->cekKamus($KataTemp))
					{
		            	$KataTemp= $kata_asal;
		            }
		        }
		    }
		}
	 
		else if((substr($KataTemp, 0,1)=="m") && ($this->IsVocal(substr($KataTemp, 1,1)))) //kurang yang ganti ke huruf b
		{
			$kata_asal=$KataTemp; 
			$KataTemp1= $this->sisipan($KataTemp);
			if($this->cekKamus($KataTemp1)) 
			{
				$KataTemp=$KataTemp1;
			}
			else
			{	
				$KataTemp= (substr_replace($KataTemp,"b",0,1));
				$KataTemp1= $this->sisipan($KataTemp);
				if(!$this->cekKamus($KataTemp1))
				{
		            $KataTemp1= $kata_asal;
		            $KataTemp= (substr_replace($KataTemp1,"p",0,1));
		            $KataTemp1= $this->sisipan($KataTemp);
		            $KataTemp=$KataTemp1;
		            if(!$this->cekKamus($KataTemp))
					{
		            	$KataTemp= $kata_asal;
		            }
		        }
			}
		}
		else if((substr($KataTemp, 0,1)=="n") && ($this->IsVocal(substr($KataTemp, 1,1))))
		{
			$kata_asal=$KataTemp;
			$KataTemp= (substr_replace($KataTemp,"t",0,1));
			if(!$this->cekKamus($KataTemp))
			{
            	$KataTemp= $kata_asal;
            }
		}

		return $KataTemp;
	}

	function sisipan($KataTemp) //perlu cek database
	{
		$kata_asal = $KataTemp;
		if($this->cekKamus($KataTemp))
			{
            	$KataTemp= $kata_asal;
            }

		else if((substr($KataTemp, 1,2)=="al")  && (strlen($KataTemp)>4))
		{
			$KataTemp= (substr_replace($KataTemp,"",1,2));
		}
		else if((substr($KataTemp, 1,2)=="in") && (strlen($KataTemp)>4))
		{
			$KataTemp= (substr_replace($KataTemp,"",1,2));
		}
		else if((substr($KataTemp, 1,2)=="um")  && ($this->IsVocal(substr($KataTemp, 3,1))) && (strlen($KataTemp)>4))
		{
			$KataTemp= (substr_replace($KataTemp,"",1,2));
		}
		else if((substr($KataTemp, 1,2)=="ar") && (strlen($KataTemp)>4))
		{
			if (substr($KataTemp, 3,2)=="ar")
			{
				$KataTemp= (substr_replace($KataTemp,"",1,4));
			}
			else
			{
				$KataTemp= (substr_replace($KataTemp,"",1,2));
			}
		}
		else if((substr($KataTemp, 0,2)=="ar") && ($this->IsVocal(substr($KataTemp, 2,1))) && (strlen($KataTemp)>3))
		{
			$KataTemp= (substr_replace($KataTemp,"",0,2));
		}
		return $KataTemp;
	}
}
?>