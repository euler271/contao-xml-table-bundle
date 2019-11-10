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
		$output = curl_exec($ch);
		curl_close($ch);

		$table = $this->htmlTableToArray($output,  $folder, $request_uri, $url);

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
    	foreach ($row->getElementsbyTagName('td') as $td){
    		//$array[] = $td->nodeValue;
			if($td->firstChild->nodeName != 'img'){
				if($td->firstChild->nodeName == 'a'){
					$href = $td->firstChild->getAttribute('href');
					if($href == '/'){
						$href = $request_uri;
					}else{
						$href = (strpos($href,".") !== false ? $origin.$href : $request_uri.'?folder='.$folder.$href);
					}
					$array[] = array($td->firstChild->textContent, $href);
				}else{
					$array[] = array($td->firstChild->textContent, '');
				}
			}
		}
		return $array;
	}
}