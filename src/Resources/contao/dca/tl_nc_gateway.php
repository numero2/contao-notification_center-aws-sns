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
$GLOBALS['TL_DCA']['tl_nc_gateway']['palettes']['aws_sns_sms'] = '{title_legend},title,type;{gateway_legend},aws_key,aws_secret,aws_region';


/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['aws_key'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_nc_gateway']['aws_key']
,   'inputType'             => 'text'
,   'eval'                  => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50']
,   'save_callback'         => [ ['\numero2\AwsSns\DCAHelper\NcLanguage', 'encryptCredentials'] ]
,   'load_callback'         => [ ['\numero2\AwsSns\DCAHelper\NcLanguage', 'decryptCredentials'] ]
,   'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['aws_secret'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_nc_gateway']['aws_secret']
,   'inputType'             => 'text'
,   'eval'                  => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50']
,   'save_callback'         => [ ['\numero2\AwsSns\DCAHelper\NcLanguage', 'encryptCredentials'] ]
,   'load_callback'         => [ ['\numero2\AwsSns\DCAHelper\NcLanguage', 'decryptCredentials'] ]
,   'sql'                   => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['aws_region'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_nc_gateway']['aws_region']
,   'inputType'             => 'select'
,   'options'               => [
        'us-east-2'
    ,   'us-east-1'
    ,   'us-west-1'
    ,   'us-west-2'
    ,   'ap-south-1'
    ,   'ap-southeast-1'
    ,   'ap-southeast-2'
    ,   'ap-northeast-1'
    ,   'ca-central-1'
    ,   'eu-central-1'
    ,   'eu-west-1'
    ,   'eu-west-2'
    ,   'eu-west-3'
    ,   'eu-north-1'
    ,   'me-south-1'
    ,   'sa-east-1'
    ,   'us-gov-west-1'
    ]
,   'reference'             => &$GLOBALS['TL_LANG']['tl_nc_gateway']['aws_regions']
,   'eval'                  => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50']
,   'sql'                   => "varchar(255) NOT NULL default ''"
];
