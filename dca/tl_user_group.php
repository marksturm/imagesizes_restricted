<?php
$GLOBALS['TL_DCA']['tl_user_group']['palettes']['default'] = str_replace(';{pagemounts_legend}', ';{restricted_imagesize_legend},allowed_imagesizes;{pagemounts_legend}', $GLOBALS['TL_DCA']['tl_user_group']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['allowed_imagesizes'] = array
		(
		'label'               => &$GLOBALS['TL_LANG']['tl_user_group']['allowed_imagesizes'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'foreignKey'              => 'tl_image_size.name',
		'eval'                    => array('multiple'=>true),
		'sql'                     => "blob NULL"
		);
?>
