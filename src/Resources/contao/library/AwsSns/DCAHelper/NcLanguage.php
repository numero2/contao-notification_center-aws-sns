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


namespace numero2\AwsSns\DCAHelper;

use Contao\Backend;
use Contao\DataContainer;
use Exception;
use numero2\AwsSns\Crypto;
use numero2\AwsSns\Validator\Validator;


class NcLanguage extends Backend {


    /**
     * Checks if the given value is a valid E.164 formatted number
     *
     * @param string $varValue
     * @param Contao\DataContainer $dc
     *
     * @return string
     */
    public function checkE164Format( $varValue, DataContainer $dc ) {

        if( strpos($varValue, ',') ) {
            $aValues = explode(',', $varValue);

            foreach( $aValues as $value ) {
                try {
                    $this->checkE164Format($value, $dc);
                } catch( Exception $e ) {
                    throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['sns_e164_number'], $value));
                }
            }

            return $varValue;
        }

        if( preg_match('/##(.+?)##/', $varValue) ) {
            return $varValue;
        }

        if( !Validator::isE164Format($varValue) ) {
            throw new Exception($GLOBALS['TL_LANG']['ERR']['sns_e164']);
        }

        return $varValue;
    }


    /**
     * Encrypts the given string
     *
     * @param string $strValue
     *
     * @return string
     */
    public function encryptCredentials( $strValue ) {

        $oCrypto = NULL;
        $oCrypto = new Crypto();

        return $oCrypto->encryptPublic($strValue);
    }


    /**
     * Decrypts the given string
     *
     * @param string $strValue
     *
     * @return string
     */
    public function decryptCredentials( $strValue ) {

        $oCrypto = NULL;
        $oCrypto = new Crypto();

        return $oCrypto->decryptPublic($strValue);
    }
}
