<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/5/17
 * Time: 7:14 PM
 */

namespace EmailBundle\Service;

use Aws\Ses\SesClient;

class Mailer
{
    protected $awsSes;

    public function __construct($awsSes)
    {
        $this->awsSes = $awsSes;
    }

    public function send(Message $message)
    {
        $parameters =  $this->awsSes;

        $sesClient = SesClient::factory($parameters['client']);
        
        $request = [];
        
        $fromName = $message->getFromName() ? : $parameters['from_name'];
        $fromAddress = $message->getFromAddress() ? : $parameters['from_address'];

        if($replyTo = $message->getReplyTo())
        {
            $replyTo = is_array($replyTo) ? $replyTo : [$replyTo];
        }
        else
        {
            $replyTo = [$fromAddress];
        }
        
        $request['Source'] = $fromName .  '<' . $fromAddress . '>';
        $request['Destination']['ToAddresses'] = is_array($to = $message->getTo()) ? $to : [$to];
        $replyTo['ReplyToAddresses'] = $replyTo;
        $request['Message']['Subject']['Data'] = $message->getSubject();
        $request['Message']['Body']['Html']['Data'] = $message->getBody();

        /** @var \Aws\Result $awsResult */
        $awsResult = $sesClient->sendEmail($request);

        return $this->awsSes;
    }
}