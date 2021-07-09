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


namespace numero2\AwsSns\Validator;


class Validator {


    /**
     * Checks if the given value is a valid E.164 formatted number
     *
     * @param string $varValue
     *
     * @return string
     */
    public function isE164Format( $varValue ): bool {

        return (bool)preg_match('/^\+[1-9]\d{1,14}$/', $varValue);
    }
}
