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
 * REGISTER HOOKS
 */
$GLOBALS['TL_HOOKS']['addCustomRegexp'][] = ['\numero2\AwsSns\Hooks\Hooks', 'validateRgxp'];


/**
 * Notification Center Gateway
 */
$GLOBALS['NOTIFICATION_CENTER']['GATEWAY']['aws_sns_sms'] = '\numero2\AwsSns\Gateway\SMS';


/**
 * Notification Center Notification Types
 */
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'] = array_merge_recursive(
    $GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'], [
        'contao' => [
            'core_form' => [
                'aws_sms_recipient_number' => ['form_*', 'formconfig_*']
            ,   'aws_sms_text'             => ['form_*', 'formconfig_*', 'formlabel_*', 'raw_data', 'admin_email']
            ]
        ]
    ]
);
