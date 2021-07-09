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


namespace numero2\AwsSns\Hooks;

use Contao\Backend;
use Contao\Widget;
use numero2\AwsSns\Validator\Validator;


class Hooks extends Backend {


    /**
     * Validate a custom regular expression
     *
     * @param string $strRgxp
     * @param mixed $varValue
     * @param \Widget $objWidget
     *
     * @return bool
     */
    public static function validateRgxp( $strRgxp, $varValue, Widget $objWidget ): bool {

        switch( $strRgxp ) {

            case 'sns_senderID':

                if( strlen($varValue) > 11 || !preg_match('/^[0-9]*[a-zA-Z][a-zA-Z0-9]*$/', $varValue) ) {
                    $objWidget->addError($GLOBALS['TL_LANG']['ERR']['sns_senderID']);
                }

                return true;
                break;

            case 'sns_e164':

                if( !Validator::isE164Format($varValue) ) {
                    $objWidget->addError($GLOBALS['TL_LANG']['ERR']['sns_e164']);
                }

                return true;
                break;
        }

        return false;
    }
}
