<?php

// Add palette to tl_module
$GLOBALS['TL_DCA']['tl_module']['palettes']['xmlTable'] = '{title_legend},name,headline,type;xmlurl,col_names,col_headings,table_headings;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['xmlurl'] = array
(
    'label'                   =>  &$GLOBALS['TL_LANG']['tl_module']['xmlurl'],
    'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['col_names'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG']['tl_module']['col_names'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'decodeEntities'=>false, 'maxlength'=>255, 'tl_class' => 'w100 clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['col_headings'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG']['tl_module']['col_headings'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'decodeEntities'=>false, 'maxlength'=>255, 'tl_class' => 'w100 clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);