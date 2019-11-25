<?php

// Add palette to tl_module
// XML to Table
$GLOBALS['TL_DCA']['tl_module']['palettes']['xmlTable'] = '{title_legend},name,headline,type;xmlurl,col_names,col_headings,table_headings,search_cols,searchfield_text;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

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

$GLOBALS['TL_DCA']['tl_module']['fields']['search_cols'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG']['tl_module']['search_cols'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'decodeEntities'=>false, 'maxlength'=>255, 'tl_class' => 'w50 clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['searchfield_text'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG']['tl_module']['searchfield_text'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'decodeEntities'=>false, 'maxlength'=>255, 'tl_class' => 'w50 clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);


//Directory Listing
$GLOBALS['TL_DCA']['tl_module']['palettes']['directoryList'] = '{title_legend},name,headline,type;directoryurl,directory_listing_type,directory_col_headings;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['directoryurl'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG']['tl_module']['directoryurl'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class' => 'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['directory_col_headings'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG']['tl_module']['directory_col_headings'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'decodeEntities'=>false, 'maxlength'=>255, 'tl_class' => 'w100 clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['directory_listing_type'] = array
(
	'label'               => &$GLOBALS['TL_LANG']['tl_module']['directory_listing_type'],
	'inputType'     	  => 'select',
	'options'             => array('directory_listing_table','directory_listing_other'),
	'reference'           => &$GLOBALS['TL_LANG']['tl_module'],
	'eval'                => array('mandatory'=>true, 'maxlength'=>64, 'tl_class'=>'w50 wizard'),
	'sql'                 => "varchar(255) NOT NULL default ''"
);