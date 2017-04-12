<?php

namespace amilna\yap;

class yZip {
	private $source = NULL;
	public $iswin = false; /* is OS Windows */
	
    public function __construct($iswin = false) {
		if (strtoupper(substr(\PHP_OS, 0, 3)) === 'WIN') {
			$iswin = true;
		} else {
			$iswin = false;	
		}
		$this->iswin = $iswin;	
	}
	
    private function _rglobRead($source, &$array = array()) {
        if (!$source || trim($source) == "") {
            $source = ".";
        }
        foreach ((array) glob($source . "/*") as $key => $value) {
            $this->_rglobRead(str_replace("//", "/", $value), $array);
        }
        foreach ((array) glob($source . "*") as $key => $value) {
            $array[] = str_replace("//", "/", $value);
        }
    }
    
    private function _zip($array, $part, $destination) {
        $zip = new \ZipArchive;
        @mkdir($destination, 0755, true);
		
		$nname = ($part !== false?str_replace("//", "/", $destination."part_{$part}.zip"):str_replace("//", "/", dirname($destination)."/".basename($destination).".zip"));
		
        if ($zip->open($nname, \ZipArchive::CREATE)) {
            foreach ((array) $array as $key => $value) {
				if (str_replace('.','',basename($value)) != basename($value))
				{
					$zip->addFile($value, str_replace(array("../", "./"), NULL, str_replace(dirname($this->source).'/','',$value)));
				}
            }
            $zip->close();
        }
    }
    
    public function zipFiles($array,$destination = "./",$limit = -1)
    {
		if (!$destination || trim($destination) == "") {
            $destination = "./";
        }
		$maxinput = count($array);
        
        if ($limit > -1)
        {
			$splitinto = (($maxinput / $limit) > round($maxinput / $limit, 0)) ? round($maxinput / $limit, 0) + 1 : round($maxinput / $limit, 0);	
			for($i = 0; $i < $splitinto; $i ++) {
				$this->_zip(array_slice($array, ($i * $limit), $limit, true), $i, $destination);
			}
		}
		else
		{
			$this->_zip($array, false, $destination);
		}
		
        unset($array);
        return;
	}
    
    public function zipDir($source = NULL, $destination = "./",$limit = -1) {
		$this->source = $source;
        $this->_rglobRead($source, $input);        
        $this->zipFiles($input,$destination,$limit);
        unset($input);
        return;
    }
    
    public function unzip($source, $destination) {
        @mkdir($destination, 0755, true);
        $g = glob($source . "*");
        $n = count($g);
        
        if ($n > 0)
        {
			$bp = explode('.', $g[0]);
			$bname = $bp[0];
			
			if ($this->iswin)
			{
				if ($n > 1)
				{
					$s = '';
					if (file_exists($bname.'.zip'))
					{
						$s = '"'.$bname.'.zip'.'"';
						$source = $bname.'.zip';
					}
					else
					{
						$source = $g[0];
					}
					
					/*
					foreach ($g as $f)
					{
						if ($f != $bname.'.zip')
						{
							$s .= ($s == ''?'':'+').'"'.$f.'"';
						}
					}
					
					$cat = shell_exec("
						copy /y ".$s.' "'.$bname.'-all.zip"'."
					");
					$source = $bname."-all.zip";	
					*/ 
				}
				
				$source = \amilna\yap\Helpers::shellvar($source);
				$destination = \amilna\yap\Helpers::shellvar($destination);
				$unzip = shell_exec('"'.dirname( __FILE__ ).'/components/7zWin/7z.exe" x "'.$source.'" -y -o"'.$destination.'" 2>&1');	
			}
			else
			{	
				if ($n > 1)
				{
					$source = \amilna\yap\Helpers::shellvar($source);
					$bname = \amilna\yap\Helpers::shellvar($bname);
					$cat = shell_exec("cat ".$source.".* > ".$bname."-all.zip &&");
					$source = $bname."-all.zip";	
				}
				
				$source = \amilna\yap\Helpers::shellvar($source);
				$destination = \amilna\yap\Helpers::shellvar($destination);
				$unzip = shell_exec("unzip -o '".$source."' -d '".$destination."'");	
			}
		}
        /*
        foreach ((array) glob($source . "*") as $key => $value) {
            $zip = new \ZipArchive;
            if ($zip->open(str_replace("//", "/", $value)) === true) {
                $zip->extractTo($destination);
                $zip->close();
            }
            else
            {
				echo $zip->open(str_replace("//", "/", $value)).' = '.$value.'<br>';	
			}
        }
        */ 
    }
    
    public function __destruct() {}
}

//$zip = new yZip;
//$zip->zipFiles(["images/a01.jpg","images/a02.jpg"], "images_zip/",500);
//$zip->zipDir("images/", "images_zip/",500);
//$zip->unzip("images_zip/", "images/");
?>
