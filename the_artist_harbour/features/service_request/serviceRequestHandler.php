<?php
require_once __DIR__ . '/../../utilities/databaseHandler.php';
class ServiceRequestHandler
{
    /**
     * Retrieves service requests for a given user.
     *
     * This method fetches service requests where the specified user is either the customer
     * or the business owner. It also retrieves the associated business display name for
     * each request.
     *
     * @param int $user_id The ID of the user whose service requests are being retrieved.
     * @return array|null An array of service request details if found, otherwise an array with an error message.
     */
    public static function retrieveRequests($user_id): array|null
    {
        $sql = "SELECT * FROM service_requests WHERE customer_user_id = $user_id OR business_user_id = $user_id";
        $requests = [];

        $results = DatabaseHandler::make_select_query($sql);

        if ($results !== null && count($results) > 0) {
            foreach ($results as $result) {
                // Retreiving business name
                $business_user_id = $result['business_user_id'];
                $business = DatabaseHandler::make_select_query("SELECT display_name FROM businesses WHERE user_id = $business_user_id");

                // Retreiving Service Name with the service ID retrieved from the last query
                $service_id = $result['service_id'];
                $service_name = DatabaseHandler::make_select_query("SELECT name FROM services WHERE id = $service_id");


                // Retreiving User Type
                $user_type = DatabaseHandler::make_select_query("SELECT user_type FROM users WHERE id = $user_id");

                $customer_user_id = $result['customer_user_id'];
                $customer_details = DatabaseHandler::make_select_query("SELECT first_name, last_name FROM users WHERE id = $customer_user_id");
                $customer_name = $customer_details[0]['first_name'] . " " . $customer_details[0]['last_name'];

                $requests[] = [
                    'request_id' => $result['id'],
                    'service_id' => $result['service_id'],
                    'created_at' => $result['created_at'],
                    'status' => $result['status'],
                    'display_name' => $business[0]['display_name'],
                    'service_name' => $service_name[0]['name'],
                    'user_type' => $user_type[0]['user_type'],
                    'price' => $result['price'],
                    'reviewed' => $result['reviewed'],
                    'customer' => $customer_name
                ];
            }
        } else {
            $requests['error'] = "No requests found.";
        }

        return $requests;
    }

    /**
     * Adds a new service request and sends a notification message.
     *
     * Retrieves the business user ID from the service ID, inserts a new service request,
     * and sends a request message if successful.
     *
     * @param int $user_id The ID of the customer making the request.
     * @param int $service_id The ID of the requested service.
     * @param string $message_text The message associated with the service request.
     * @param string $price The price if the service is non-negotiable, otherwise leave empty and will set to NULL
     * @return bool True on success, false on failure.
     */
    public static function insertRequest($user_id, $service_id, $message_text, $price = 0): bool
    {
        // Get business_user_id from the service_id
        $business_id_query = DatabaseHandler::make_select_query("SELECT business_id FROM services WHERE id = $service_id");
        $business_id = $business_id_query[0]['business_id'];
        $business_user_id_query = DatabaseHandler::make_select_query("SELECT user_id FROM businesses WHERE id = $business_id ");
        $business_user_id = $business_user_id_query[0]['user_id'];


        // Inserting Service Request
        $sql = "INSERT INTO service_requests (service_id, customer_user_id, business_user_id, message, status, price, created_at) 
                VALUES ($service_id, $user_id, $business_user_id, '$message_text', 'pending', $price, NOW())";

        $result = DatabaseHandler::make_modify_query($sql);

        // Checks if service request was added and inserts message if it was
        if ($result != null) {
            self::sendRequestMessage($user_id, $business_user_id, $message_text);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sends a message regarding a service request.
     *
     * This private method inserts a message into the messages table with the provided
     * sender ID, receiver ID, and message text.
     *
     * @param int $sender_id The ID of the user sending the message.
     * @param int $receiver_id The ID of the user receiving the message.
     * @param string $message_text The message content.
     * @return void
     */
    private static function sendRequestMessage($sender_id, $receiver_id, $message_text): void
    {
        $sql = "INSERT INTO messages (sender_id, receiver_id, text, status, created_at)
            VALUES ($sender_id, $receiver_id, '$message_text', 'accepted', NOW())";

        $result = DatabaseHandler::make_modify_query($sql);
    }
}
?>