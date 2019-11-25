<?php

namespace Jl\ContaoXmlTableBundle\Module;

class DirectoryListModule extends \Module
{
    /**
     * @var string
     */
    protected $strTemplate = 'mod_directoryList';

    /**
     * Displays a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $template = new \BackendTemplate('be_wildcard');

            $template->wildcard = '### '.utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['directoryList'][0]).' ###';
            $template->title = $this->headline;
            $template->id = $this->id;
            $template->link = $this->name;
            $template->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $template->parse();
        }

        return parent::generate();
    }

    /**
     * Generates the module.
     */
    protected function compile()
    {
    	$folder = $_GET['folder'];
		$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

		//https://changelogs.kixdesk.com/
    	$url = $this->directoryurl.($folder == '/' ? '' : $folder);

    	$col_headings = $this->directory_col_headings;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/xml'));
		curl_setopt($ch, CURLOPT_HEADER, true);
		$output = curl_exec($ch);
		$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		curl_close($ch);

		//Redirect to source, if the location is no subfolder (content type html)
		if(strpos($contentType, 'text/html') === false){
			header("Location: $url");
			exit;
		}


		if($this->directory_listing_type == 'directory_listing_table'){
			$table = $this->htmlTableToArray($output,  $folder, $request_uri, $url);
		}else{
			$table = $this->directoryListToTable($output,  $folder, $request_uri, $url);
		}

		$this->Template->table = $table;
		$this->Template->headings = preg_split ("/\;/", $col_headings, -1, PREG_SPLIT_NO_EMPTY);

    }

    private function htmlTableToArray($html,  $folder, $request_uri, $origin){
    	$array = array();

		$dom = new \DOMDocument();
		$dom->loadHTML($html);
		$dom->preserveWhiteSpace = false;
		$detail = $dom->getElementsByTagName('tr');

		foreach ($detail as $row){
			$row_array = $this->rowToArray($row,  $folder, $request_uri, $origin);

			if($row_array != array()){
				$array[] = $row_array;
			}
		}

		return $array;
	}

    private function rowToArray($row, $folder, $request_uri, $origin){
    	$array = array();
    	$i = 0;
    	foreach ($row->getElementsbyTagName('td') as $td){
    		//$array[] = $td->nodeValue;
			if($td->firstChild->nodeName != 'img'){
				if($td->firstChild->nodeName == 'a'){
					$href = $td->firstChild->getAttribute('href');
					if($href[0] == '/'){
						$plen = strlen(parse_url($this->directoryurl)['path']);
						$href = $request_uri.(strlen(substr($href, $plen) > 0) ? '?folder='.substr($href, $plen) : '');
					}else{
						$isFile = strpos($href,".") !== false || $href[strlen($href)-1] !== '/';
						$href = ($isFile ? $origin.$href : $request_uri.'?folder='.$folder.$href);
					}
					$array[] = array($td->firstChild->textContent, $href);
				}else{
					if($i != 4) { $array[] = array($td->firstChild->textContent, ''); }
				}
			}
			$i++;
		}
		return $array;
	}

	private function directoryListToTable($html,  $folder, $request_uri, $origin){
    	$html = $this->get_string_between($html, '<hr>', '<hr>');

    	$dom = new \DOMDocument();
		$dom->loadHTML($html);
		$dom->preserveWhiteSpace = false;

		$table = array();

		foreach ($dom->getElementsByTagName('a') as $a){
			$href = $a->getAttribute('href');
			if($href[0] == '/'){
				$plen = strlen(parse_url($this->directoryurl)['path']);
				$href = $href = $request_uri.(strlen(substr($href, $plen) > 0) ? '?folder='.substr($href, $plen) : '');
			}else{
				$isFile = strpos($href,".") !== false || $href[strlen($href)-1] !== '/';
				$href = ($isFile ? $origin.$href : $request_uri.'?folder='.$folder.$href);
			}

			$description = explode(" ", trim(preg_replace('/\s+/', ' ', $a->nextSibling->textContent)));
			if(sizeof($description) <= 1){
				$description = array();
			}
			$table[] = array(array($a->textContent, $href), array( $description[0]." ".$description[1], ''), array($description[2], ''));
		}

    	return $table;
	}

	function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	function getContentType($url)
	{
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		$content = curl_exec ($ch);
		$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		curl_close ($ch);
		return $contentType;
	}
}