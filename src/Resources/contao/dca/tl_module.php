<?php

// Add palette to tl_module
$GLOBALS['TL_DCA']['tl_module']['palettes']['xmlTable'] = '{title_legend},name,headline,type,xmlurl'/*,table_headings.*/.';{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['xmlurl'] = array
(
    'label'                   =>  "Link zur XML-Datei",//&$GLOBALS['TL_LANG']['tl_module']['load_default_javascript'],
    'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
/*
$GLOBALS['TL_DCA']['tl_module']['fields']['table_headings'] = array
(
	'label'                   =>  "Spaltennamen, kommasepariert",
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class' => 'w100'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);*/