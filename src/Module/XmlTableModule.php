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
		$data = array();

		if($this->xmlurl == ''){
			$output = '<xml><issue><ticket_id>309296</ticket_id><title>FireFox SearchEngine wirft Invalid Format Fehler</title><package>KIX</package><state>eingeplant</state><summary></summary><workaround></workaround><solved_in_release> </solved_in_release></issue><issue><ticket_id>308607</ticket_id><title>AgentTicketPhone / AgentTicketEmail dynamische Felder werden nicht gesetzt nach Aus- und  [...]</title><package>KIX</package><state>bereit zum Test</state><summary>Dynamische Felder werden aus der Erstellmaske nicht übernommen, wenn diese durch ACL-Regeln ausgeblendet werden und durch die Queueauswahl wieder eingeblendet werden.</summary><workaround></workaround><solved_in_release> </solved_in_release></issue><issue><ticket_id>308315</ticket_id><title>Artikel bearbeiten prüft nur Gruppen-Zuordnung und ignoriert Gruppen per Rollen-Zuordnung</title><package>KIX</package><state>bereit zum Test</state><summary>AgentArticleEdit ignoriert Berechtigungen, welche nur über die Rolle dem Agenten zugewiesen sind und nicht direkt über die Gruppe. Widget zum Löschen des Artikels steht nach Konfiguration nicht zur Verfügung.</summary><workaround>In Datei /opt/kix/Kernel/Modules/AgentArticleEdit.pm  Zeile 218 ersetzen durch:<br>my %GroupList = $GroupObject→PermissionUserGet(</workaround><solved_in_release> </solved_in_release></issue><issue><ticket_id>308240</ticket_id><title>Internal Server Error bei Verwendung von \'Wide character\' mit DF Richtext</title><package>KIXPro</package><state>bereit zum Test</state><summary>Wenn man im Quelltext des Richtexteditors direkt einen \'Wide character\' (z.B. \'*\') einfügt und dies speichert, kommt es beim laden des Feldes zum Internal Server Error.</summary><workaround></workaround><solved_in_release> 11/2019</solved_in_release></issue></xml>';
		}

		$output = str_replace('<br>', '[br]', $output);

		try{
			$data = simplexml_load_string($output);
		}catch(\Exception $e){
			$error = "Could not parse XML File!";
		}

		$fields = preg_split("/\;/", $this->col_names);

		$dataShown = array();
		foreach ($data as $element){
			$element = json_decode(json_encode($element), True);

			$elementShown = array();

			if($fields != array()){
				foreach ($fields as $field){
					$elementShown[$field] = (is_array($element[$field]) ? '' : $element[$field]);
				}
			}else{
				foreach ($element as $field){
					$elementShown[] = (is_array($field) ? '' : $field);
				}
			}

			$dataShown[] = $elementShown;

		}

		$this->Template->headings = preg_split ("/\;/", $this->col_headings);
		$this->Template->error = $error;
		$this->Template->data = $dataShown;

    }
}