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

namespace numero2\AwsSns\MessageDraft;

use NotificationCenter\MessageDraft\MessageDraftInterface;
use NotificationCenter\Model\Language;
use NotificationCenter\Model\Message;
use NotificationCenter\Util\StringUtil;


class SMSMessageDraft implements MessageDraftInterface {


    /**
     * Message
     * @var Message
     */
    protected $objMessage = null;

    /**
     * Language
     * @var Language
     */
    protected $objLanguage = null;

    /**
     * Tokens
     * @var array
     */
    protected $arrTokens = array();


    /**
     * Construct the object
     *
     * @param Message $objMessage
     * @param Language $objLanguage
     * @param Tokens $arrTokens
     */
    public function __construct( Message $objMessage, Language $objLanguage, $arrTokens ) {

        $this->objMessage = $objMessage;
        $this->objLanguage = $objLanguage;
        $this->arrTokens = $arrTokens;
    }


    /**
     * {@inheritdoc}
     */
    public function getTokens() {
        return $this->arrTokens;
    }


    /**
     * {@inheritdoc}
     */
    public function getMessage() {
        return $this->objMessage;
    }


    /**
     * {@inheritdoc}
     */
    public function getLanguage() {
        return $this->objLanguage->language;
    }


    /*
     * @return string
     */
    public function getText() {

        $strText = $this->objLanguage->aws_sms_text;
        $strText = StringUtil::recursiveReplaceTokensAndTags($strText, $this->arrTokens, StringUtil::NO_TAGS);
        return $strText;
    }


    /*
     * @return string
     */
    public function getRecipientNumber() {

        $strText = $this->objLanguage->aws_sms_recipient_number;
        $strText = StringUtil::recursiveReplaceTokensAndTags($strText, $this->arrTokens, StringUtil::NO_TAGS);
        return $strText;
    }


    /*
     * @return string
     */
    public function getSenderName() {
        return $this->objLanguage->aws_sms_sender_name;
    }

    /*
     * @return string
     */
    public function getSMSType() {
        return $this->objLanguage->aws_sms_type;
    }
}
