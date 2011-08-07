<?php
namespace Limu110u\SwiftMailer\Localize\Japanese;

use Limu110u\SwiftMailer\Localize\Japanese\Mime\Headers\UnstructuredHeader;

/**
 * This class helps you to send e-mail in Japanese ISO-2022-JP(7bit) 
 * by using SwiftMailer.
 *
 * @see http://www.kuzilla.co.jp/article.php/20100301symfony
 * @author limu110u@gmail.com
 * @version $Id:$
 */
class Message extends \Swift_Message
{
  public function __construct($subject = null, $body = null)
  {
    mb_language('ja');
    mb_internal_encoding('UTF-8');

    $contentType = 'text/plain';
    $charset = 'iso-2022-jp';

    call_user_func_array(
      array($this, '\Swift_Mime_SimpleMessage::__construct'),
      \Swift_DependencyContainer::getInstance()
        ->createDependenciesFor('mime.message')
    );

    $this->getHeaders()->remove('Subject');
    $header = new UnstructuredHeader(
      'Subject',
      new \Swift_Mime_HeaderEncoder_Base64HeaderEncoder(),
      new \Swift_Mime_Grammar()
    );
    $header->setCharset($charset);
    $this->getHeaders()->set($header);

    $this->sortHeader();

    $this->setCharset($charset);
    $this->setContentType($contentType);

    $this->setEncoder(\Swift_Encoding::get7BitEncoding());

    $this->setSubject($subject);
    $this->setBody($body);
  }

  public static function newInstance($subject = null, $body = null, $contentType = null, $charset = null)
  {
    return new self($subject, $body);
  }

  public function setSubject($subject)
  {
    return parent::setSubject($this->_mb_encode_mimeheader($subject));
  }
  
  public function addFrom($address, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::addFrom($address, $name);
  }

  public function setFrom($addresses, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::setFrom($addresses, $name);
  }
  
  public function setSender($address, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    } 
    return parent::setSender($address, $name);
  } 

  public function addReplyTo($address, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::addReplyTo($address, $name);
  }

  public function setReplyTo($addresses, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::setReplyTo($addresses, $name);
  }

  public function addTo($address, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::addTo($address, $name);
  }

  public function setTo($addresses, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::setTo($addresses, $name);
  }

  public function addCc($address, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::addCc($address, $name);
  }

  public function setCc($addresses, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::setCc($addresses, $name);
  }

  public function addBcc($address, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::addBcc($address, $name);
  }

  public function setBcc($addresses, $name = null)
  {
    if (isset($name))
    {
      $name = $this->_mb_encode_mimeheader($name);
    }
    return parent::setBcc($addresses, $name);
  }
  
  public function setBody($body, $contentType = null, $charset = null)
  {
    return parent::setBody(mb_convert_encoding($body, $this->getCharset(), mb_internal_encoding()));
  }


  private function sortHeader()
  {
    $this->getHeaders()->defineOrdering(array(
      'Return-Path',
      'Sender',
      'Message-ID',
      'Date',
      'Subject',
      'From',
      'Reply-To',
      'To',
      'Cc',
      'Bcc',
      'MIME-Version',
      'Content-Type',
      'Content-Transfer-Encoding'
    ));
  }

  private function _mb_encode_mimeheader($value)
  {
    return mb_encode_mimeheader($value, $this->getCharset(), 'B', "\r\n");
  }

}

