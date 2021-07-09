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


namespace numero2\AwsSns\Gateway;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Contao\System;
use NotificationCenter\Gateway\Base;
use NotificationCenter\Gateway\GatewayInterface;
use NotificationCenter\MessageDraft\MessageDraftFactoryInterface;
use NotificationCenter\Model\Language;
use NotificationCenter\Model\Message;
use numero2\AwsSns\Crypto;
use numero2\AwsSns\MessageDraft\SMSMessageDraft;
use numero2\AwsSns\Validator\Validator;


class SMS extends Base implements GatewayInterface, MessageDraftFactoryInterface {


    /**
     * SnSClient
     * @var SnsClient
     */
    protected $SnSClient;


    /**
     * @inheritDoc
     */
    public function send( Message $objMessage, array $arrTokens, $strLanguage = '' ) {

        $objGateway = $objMessage->getRelated('gateway');

        if( empty($objGateway->aws_region) || empty($objGateway->aws_key) || empty($objGateway->aws_secret) ) {

            System::log(sprintf('Could not send message via AWS SNS (Message ID: %s) credentials missing in gateway', $objMessage->id), __METHOD__, TL_ERROR);
            return false;
        }

        $oCrypto = null;
        $oCrypto = new Crypto();

        $this->SnSClient = new SnsClient([
            'region' => $objGateway->aws_region,
            'credentials' => [
                'key'    => $oCrypto->decryptPublic($objGateway->aws_key),
                'secret' => $oCrypto->decryptPublic($objGateway->aws_secret),
            ],
            'version' => '2010-03-31'
        ]);

        $objDraft = $this->createDraft($objMessage, $arrTokens, $strLanguage);

        if( $objDraft === null ) {
            System::log(sprintf('Could not create draft message for AWS SNS SMS (Message ID: %s)', $objMessage->id), __METHOD__, TL_ERROR);
            return false;
        }

        try {
            return $this->sendDraft($objDraft);
        } catch (\Exception $e) {
            System::log(sprintf('Could not send AWS SNS SMS for message ID %s: %s', $objMessage->id, $e->getMessage()), __METHOD__, TL_ERROR);
        }

        return false;
    }


    /**
     * @param SMSMessageDraft $objDraft
     */
    public function sendDraft( SMSMessageDraft $objDraft ) {

        if( !Validator::isE164Format($objDraft->getRecipientNumber()) ) {
            System::log(sprintf('Could not send AWS SNS SMS for message ID %s as given number "%s" is not E.164 formatted', $objDraft->getMessage()->id, $objDraft->getRecipientNumber()), __METHOD__, TL_ERROR);
            return false;
        }

        $messageAttributes = [
            'AWS.SNS.SMS.SMSType' => ['StringValue' => $objDraft->getSMSType(), 'DataType' => 'String']
        ];

        if( !empty($objDraft->getSenderName()) ) {
            $messageAttributes['AWS.SNS.SMS.SenderID'] = ['StringValue' => $objDraft->getSenderName(), 'DataType' => 'String'];
        }

        try {

            $result = $this->SnSClient->publish([
                'Message' => $objDraft->getText(),
                'PhoneNumber' => $objDraft->getRecipientNumber(),
                'MessageAttributes' => $messageAttributes
            ]);

            System::log(sprintf(
                'Successfully dispatched message ID %s to AWS SNS, phone: %s, MessageId: %s',
                $objDraft->getMessage()->id,
                $objDraft->getRecipientNumber(),
                $result->get('MessageId')
            ), __METHOD__, TL_GENERAL);

        } catch( AwsException $e ) {

            System::log(sprintf('AWS SNS SMS error for message ID %s: %s', $objDraft->getMessage()->id, $e->getMessage()), __METHOD__, TL_ERROR);
            return false;
        }

        return true;
    }


    /**
     * @inheritDoc
     */
    public function createDraft( Message $objMessage, array $arrTokens, $strLanguage='' ) {

        if( $strLanguage == '' ) {
            $strLanguage = $GLOBALS['TL_LANGUAGE'];
        }

        if( ($objLanguage = Language::findByMessageAndLanguageOrFallback($objMessage, $strLanguage)) === null ) {

            System::log(sprintf('Could not find matching language or fallback for message ID "%s" and language "%s".',$objMessage->id, $strLanguage), __METHOD__, TL_ERROR);
            return null;
        }

        return new SMSMessageDraft($objMessage, $objLanguage, $arrTokens);
    }
}
