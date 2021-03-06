<?php
/**
 * Created by MeaningCloud Support Team.
 * Date: 07/01/20
 */

namespace MeaningCloud;


class MCClassRequest extends MCRequest {


  private $endpoint = 'class-2.0';
  private $otherParams = array();
  private $extraHeaders = array();
  private $type = MCRequest::CONTENT_TYPE_TXT;


  /**
   * MCClassRequest constructor
   *
   * @param string $key
   * @param string $model
   * @param string $txt
   * @param string $url
   * @param string $doc
   * @param array $otherParams
   * @param array $extraHeaders
   * @param string $server
   */
  public function __construct($key, $model, $txt="", $url="", $doc="",
                              $otherParams = array(), $extraHeaders = array(),
                              $server='https://api.meaningcloud.com/') {

    if(substr($server, -1) != '/') {
      $server .= '/';
    }
    $urlAPI = $server . $this->endpoint;
    parent::__construct($urlAPI, $key);

    $this->otherParams = $otherParams;
    $this->extraHeaders = $extraHeaders;

    if(!empty($txt)) {
      $this->type = MCRequest::CONTENT_TYPE_TXT;
      $this->setContentTxt($txt);
    } elseif(!empty($url)) {
      $this->type = MCRequest::CONTENT_TYPE_URL;
      $this->setContentUrl($url);
    } elseif(!empty($doc)) {
      $this->type = MCRequest::CONTENT_TYPE_FILE;
      $this->setContentFile($doc);
    }

    $this->addParam('model', $model);
    array_walk($otherParams, [$this, 'addParam']);
  }


  /**
   * Sends request to the Text Classification API
   *
   * @return MCClassResponse object
   */
  public function sendClassRequest() {
    $response = $this->sendRequest($this->extraHeaders);
    $classResponse = new MCClassResponse($response);
    return $classResponse;
  }

}
