<?php
namespace VEA\lib\interfaces;

/**
 * Connection interface
 *
 * @author GreeveX <greevex@gmail.com>
 */
interface connection
{

    /**
     * Call api method with params
     *
     * @param string $method - api method name
     * @param array $params - api method params
     * @param array $api_type - http | ssl
     *
     * @return array - api response
     */
    public function api($method, $params = array(), $api_type = null);

    /**
     * Call api method with params over http protocol
     *
     * @param $method - api method name
     * @param array $params - api method params
     *
     * @return array - api response
     */
    public function api_http($method, $params = array());

    /**
     * Call api method with params over ssl protocol
     *
     * @param $method - api method name
     * @param array $params - api method params
     *
     * @return array - api response
     */
    public function api_ssl($method, $params = array());

    /**
     * Authorize using OAuth2
     * Returns true on success or false on failure
     *
     * @return boolean
     */
    public function authorize();

    /**
     * Validate result for an errors
     *
     * @param Array $result
     */
    public function validate(Array $result);

    /**
     * Switch to api requests throw HTTP protocol
     *
     */
    public function switchToHttp();

    /**
     * Switch to api requests throw SSL protocol
     *
     */
    public function switchToSsl();

    /**
     * Get OAuth2 access token.
     *
     * @return string
     */
    public function getAccessToken();

    /**
     * Set OAuth2 access token.
     *
     * @param string $access_token
     */
    public function setAccessToken($access_token);

    /**
     * Get auth url
     *
     * @param Array scope
     */
    public function getAuthUrl(Array $scope = '');

    /**
     * Get an object of last error
     *
     * @return \Exception
     */
    public function getLastError();

    /**
     * Get application ID
     *
     * @return integer
     */
    public function getAppId();

    /**
     * Get application secret
     *
     * @return string
     */
    public function getAppSecret();

}