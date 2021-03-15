<?php
/**
 * Created by PhpStorm.
 * User: Oleksii
 * Date: 26/02/2019
 * Time: 09:41
 */

namespace BankId;


use BankId\Exceptions\ValidationException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class BankIdService
{
    protected $api_url;
    protected $server_ip;
    protected $Client;

    public function __construct(string $api_url, string $server_ip, array $client_options)
    {
        // Validate url
        if (filter_var($api_url, FILTER_VALIDATE_URL)) {
            $this->api_url = $api_url;
        } else {
            throw new ValidationException("url '$api_url' is not a valid");
        }

        //Validate ip
        if (filter_var($server_ip, FILTER_VALIDATE_IP)) {
            $this->$server_ip = $server_ip;
        } else {
            throw new ValidationException("url '$server_ip' is not a valid");
        }

        $client_options['base_uri'] = $this->api_url;
        $client_options['json'] = true;

        $this->Client = new Client($client_options);
    }


    /**
     * @param string $personalNumber The personal number of the user. String. 12 digits. Century must be included.
     * @return array
     * @throws ClientException
     */
    public function getAuthResponse($personalNumber)
    {
        $parameters = [
            'personalNumber' => $personalNumber,
            'endUserIp' => $this->server_ip,
            'requirement' => [
                'allowFingerprint' => true,
            ],
        ];
        $responseData = $this->Client->post('auth', ['json' => $parameters]);
        $response = $this->decodeBody($responseData);

        return $response;
    }


    /**
     * @param string $personal_number The personal number of the user. String. 12 digits. Century must be included.
     * @param string $user_visible_data The text to be displayed and signed.
     * @param string $user_hidden_data Data not displayed to the user
     * @return OrderResponse
     * @throws ClientException
     */
    public function getSignResponse(string $personal_number, $user_visible_data, $user_hidden_data = '')
    {


        $parameters = [
            'personalNumber' => $personal_number,
            'endUserIp' => $this->server_ip,
            'userVisibleData' => base64_encode($user_visible_data),
            'requirement' => [
                'allowFingerprint' => true,
            ],
        ];
        if (!empty($userHiddenData)) {
            $parameters['userNonVisibleData'] = base64_encode($user_hidden_data);
        }
        $responseData = $this->Client->post('sign', ['json' => $parameters]);

        return new OrderResponse($responseData);
    }


    /**
     * @param string $orderRef Used to collect the status of the order.
     * @return CollectResponse
     * @throws ClientException
     */
    public function collectResponse($orderRef)
    {
        $responseData = $this->Client->post('collect', ['json' => ['orderRef' => $orderRef]]);
        return new CollectResponse($responseData);
    }


    /**
     * @param string $orderRef Used to collect the status of the order.
     * @return bool
     * @throws ClientException
     */
    public function cancelOrder($orderRef)
    {
        $responseCode = $this->Client->post('cancel', ['json' => ['orderRef' => $orderRef]])->getStatusCode();
        return $responseCode === 200;
    }

}