<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2021 Leo Feyer
 *
 * @package   AWS SNS
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   Commercial
 * @copyright 2021 numero2 - Agentur für digitales Marketing
 */


/**
 * Modify fields of tl_form_field
 */
$index = array_search('phone', $GLOBALS['TL_DCA']['tl_form_field']['fields']['rgxp']['options']);
if( $index !== false ) {
    array_insert($GLOBALS['TL_DCA']['tl_form_field']['fields']['rgxp']['options'], $index+1, 'sns_e164');
} else {
    $GLOBALS['TL_DCA']['tl_form_field']['fields']['rgxp']['options'][] = 'sns_e164';
}
