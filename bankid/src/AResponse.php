<?php
/**
 * Created by PhpStorm.
 * User: Oleksii
 * Date: 04/03/2019
 * Time: 05:44
 */

namespace BankId;

use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractResponseModel
 *
 * Constructor convert ResponseInterface to object properties
 */
class AResponse
{

    /**
     * AbstractResponseModel constructor.
     * @param ResponseInterface|null $response
     */
    public function __construct(ResponseInterface $response = null)
    {
        if (null !== $response) {
            $responseText = $response->getBody()->getContents();
            $responseArray = (array)json_decode($responseText);
            foreach ($responseArray as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}