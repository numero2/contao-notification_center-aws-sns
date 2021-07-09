<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2021 Leo Feyer
 *
 * @package   ROC Fertigung24 GmbH
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   Commercial
 * @copyright 2021 numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\AwsSns;

use Contao\System;


class Crypto {


    /**
     * Public key used for encryption
     * @var string
     */
    private $publicKey;


    /**
     * Cipher used
     * @var string
     */
    const CIPHER = "AES-256-CTR";


    /**
     * Constructor
     */
    function __construct( $public=NULL ) {

        if( $public ) {
            $this->publicKey = $public;
        } else {
            $this->publicKey = System::getContainer()->getParameter('kernel.secret');
        }
    }


    /**
     * Encrypts the given message
     *
     * @param string $strMessage
     *
     * @return string
     */
    public function encryptPublic( $strMessage ) {

        if( $strMessage === null || $strMessage === '' ) {
            return '';
        }

        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($strMessage, self::CIPHER, $this->publicKey, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $this->publicKey, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

        return $ciphertext;
    }


    /**
     * Decrypts the given message
     *
     * @param string $strCrypted
     *
     * @return string
     */
    public function decryptPublic( $strCrypted ) {

        if( $strCrypted === null || $strMessage === '' ) {
            return '';
        }

        $c = base64_decode($strCrypted);
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $sha2len=32;
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);

        if( !$iv || !$hmac || !$ciphertext_raw ) {
            return '';
        }

        $original_plaintext = openssl_decrypt($ciphertext_raw, self::CIPHER, $this->publicKey, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $this->publicKey, $as_binary=true);

        if( hash_equals($hmac, $calcmac) ) {
            return $original_plaintext;
        }

        return '';
    }
}
