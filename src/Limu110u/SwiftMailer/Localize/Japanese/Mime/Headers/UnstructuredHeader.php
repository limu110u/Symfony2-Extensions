<?php
namespace Limu110u\SwiftMailer\Localize\Japanese\Mime\Headers;

class UnstructuredHeader extends \Swift_Mime_headers_UnstructuredHeader
{
  public function getFieldBody()
  {
    if (!$this->getCachedValue())
    {
      if (\strcasecmp($this->getCharset(), 'iso-2022-jp') === 0)
      {
        $this->setCachedValue($this->getValue());
      }
      else
      {
        parent::getFieldBody();
      }
    }
    return $this->getCachedValue();
  }
}

