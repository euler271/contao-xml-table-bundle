<?php

namespace Jl\ContaoXmlTableBundle\Module;

class XmlTableModule extends \Module
{
    /**
     * @var string
     */
    protected $strTemplate = 'mod_xmlTable';

    /**
     * Displays a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $template = new \BackendTemplate('be_wildcard');

            $template->wildcard = '### '.utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['helloWorld'][0]).' ###';
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
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->xmlurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/xml'));
		$output = curl_exec($ch);
		curl_close($ch);
		$error = '';
		$dataset = array();
		
		try{
			$dataset = simplexml_load_string($output);
		}catch(Exception $e){
			$error = "Cannot parse XML File!";	
		}

		$this->Template->headings = preg_split ("/\;/", $this->table_headings);
		$this->Template->error = $error;
		$this->Template->dataset = json_decode(json_encode((array) $dataset));

    }
}