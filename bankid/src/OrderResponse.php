<?php
/**
 * Created by PhpStorm.
 * User: Oleksii
 * Date: 04/03/2019
 * Time: 05:45
 */

namespace BankId;

/**
 * Class OrderResponse
 *
 * Response from auth and sign methods
 *
 * @property string $orderRef Used to collect the status of the order.
 * @property string $autoStartToken Used as reference to this order when the client is started automatically.
 */
class OrderResponse extends AResponse
{

}