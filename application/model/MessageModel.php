<?php

/**
 * NoteModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class MessageModel
{
    /**
     * Get all Messages
     * @return array an array with several objects (the results)
     */
    public static function getAllMessagesByUser($toUserID)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT MessageText, SenderID, Time FROM Messages WHERE (SenderID = :user_id AND ReceiverID = :toUserID) OR (SenderID = :toUserID AND ReceiverID = :user_id)";
        $query = $database->prepare($sql);

        $userID = Session::get("user_id");

        $params = [
            ':user_id' => $userID,
            ':toUserID' =>  $toUserID // Stelle sicher, dass $toUserID definiert ist
        ];

        // Query ausführen
        $query->execute($params);

        // Ergebnisse abrufen
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function sendMessage($toUserID, $messageString)
    {

        $userID = Session::get('user_id');
        $database = DatabaseFactory::getFactory()->getConnection();

        date_default_timezone_set("Europe/Vienna");
        $currentTime = date("Y-m-d H:i:s");

        // Prepare the SQL statement to prevent SQL injection
        $sql = "INSERT INTO Messages (SenderID, ReceiverID, Time, MessageText) VALUES (:userID, :toUserID, :currentTime, :messageString)";
        $query = $database->prepare($sql);

        // Bind parameters securely
        $query->bindParam(':userID', $userID, PDO::PARAM_INT);
        $query->bindParam(':toUserID', $toUserID, PDO::PARAM_INT);
        $query->bindParam(':currentTime', $currentTime);
        $query->bindParam(':messageString', $messageString);

        // Execute the query
        $query->execute();
    }
}
