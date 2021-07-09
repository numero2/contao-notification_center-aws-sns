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
 * Modify palettes
 */
$GLOBALS['TL_DCA']['tl_nc_language']['palettes']['aws_sns_sms'] = '{general_legend},language,fallback;{meta_legend},aws_sms_type,aws_sms_sender_name,aws_sms_recipient_number;{content_legend},aws_sms_text';


/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_nc_language']['fields']['aws_sms_type'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_nc_language']['aws_sms_type']
,   'inputType'             => 'select'
,   'options'               => ['Promotional', 'Transactional']
,   'reference'             => &$GLOBALS['TL_LANG']['tl_nc_language']['aws_sms_types']
,   'eval'                  => ['mandatory'=>true, 'maxlength'=>255, 'helpwizard'=>true,'tl_class'=>'w50']
,   'explanation'           => 'aws_sns_sms_type'
,   'sql'                   => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['aws_sms_sender_name'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_nc_language']['aws_sms_sender_name']
,   'inputType'             => 'text'
,   'eval'                  => ['rgxp'=>'sns_senderID', 'maxlength'=>11, 'tl_class'=>'w50']
,   'sql'                   => "varchar(11) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['aws_sms_recipient_number'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_nc_language']['aws_sms_recipient_number']
,   'inputType'             => 'text'
,   'save_callback'         => [ ['\numero2\AwsSns\DCAHelper\NcLanguage', 'checkE164Format'] ]
,   'eval'                  => ['mandatory'=>true, 'rgxp'=>'nc_tokens', 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'w50']
,   'sql'                   => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['aws_sms_text'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_nc_language']['aws_sms_text']
,   'inputType'             => 'textarea'
,   'eval'                  => ['mandatory'=>true, 'rgxp'=>'nc_tokens', 'decodeEntities'=>true, 'maxlength'=>255]
,   'sql'                   => "mediumtext NULL"
];
