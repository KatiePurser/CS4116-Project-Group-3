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
        // Cast to integer to avoid SQL injection
        $user_id = (int) $user_id;

        $sql = "
                SELECT 
                    sr.id AS request_id,
                    sr.service_id,
                    sr.created_at,
                    sr.status,
                    sr.min_price,
                    sr.max_price,
                    sr.reviewed,
                    b.display_name,
                    s.name AS service_name,
                    u.user_type,
                    cu.first_name AS customer_first_name,
                    cu.last_name AS customer_last_name
                FROM service_requests sr
                LEFT JOIN businesses b ON sr.business_user_id = b.user_id
                LEFT JOIN services s ON sr.service_id = s.id
                LEFT JOIN users u ON u.id = $user_id
                LEFT JOIN users cu ON sr.customer_user_id = cu.id
                WHERE sr.customer_user_id = $user_id OR sr.business_user_id = $user_id
                ORDER BY 
                    CASE sr.status
                        WHEN 'pending' THEN 0
                        WHEN 'approved' THEN 1
                        WHEN 'in progress' THEN 2
                        WHEN 'completed' THEN 3
                        WHEN 'declined' THEN 4
                        ELSE 5 -- catch-all for unknown statuses
                    END,
                    sr.created_at DESC
            ";



        $results = DatabaseHandler::make_select_query($sql);

        if (!empty($results)) {
            $requests = [];
            foreach ($results as $result) {
                $customer_name = $result['customer_first_name'] . ' ' . $result['customer_last_name'];
                $requests[] = [
                    'request_id' => $result['request_id'],
                    'service_id' => $result['service_id'],
                    'created_at' => $result['created_at'],
                    'status' => $result['status'],
                    'display_name' => $result['display_name'],
                    'service_name' => $result['service_name'],
                    'user_type' => $result['user_type'],
                    'min_price' => $result['min_price'],
                    'max_price' => $result['max_price'],
                    'reviewed' => $result['reviewed'],
                    'customer' => $customer_name
                ];
            }
            return $requests;
        } else {
            return [];
        }
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
     * @param string $min_price The minimum price of the service even if the price is non-negotiable
     * @param string $max_price The maximum prcie of the service
     * @return bool True on success, false on failure.
     */
    public static function insertRequest($user_id, $service_id, $message_text, $min_price, $max_price): bool
    {
        // Get business_user_id from the service_id
        $business_id_query = DatabaseHandler::make_select_query("SELECT business_id FROM services WHERE id = $service_id");
        $business_id = $business_id_query[0]['business_id'];
        $business_user_id_query = DatabaseHandler::make_select_query("SELECT user_id FROM businesses WHERE id = $business_id ");
        $business_user_id = $business_user_id_query[0]['user_id'];


        // Inserting Service Request
        $sql = "INSERT INTO service_requests (service_id, customer_user_id, business_user_id, message, status, min_price, max_price, created_at) 
                VALUES ($service_id, $user_id, $business_user_id, '$message_text', 'pending', $min_price, $max_price, NOW())";

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
        $sql = "CALL SendMessage($sender_id, $receiver_id, '$message_text', 'accepted')";
        $result = DatabaseHandler::make_modify_query($sql);
    }
}
?>