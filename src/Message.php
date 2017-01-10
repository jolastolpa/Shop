<?php 
/* CREATE TABLE `Message`(
message_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
receiver_id INT NOT NULL, 
sender_id INT NOT NULL,
message_text VARCHAR(500) ,
message_title VARCHAR(100),
creationDate datetime NOT NULL,
FOREIGN KEY(receiver_id) REFERENCES User(id),
FOREIGN KEY (sender_id) REFERENCES Admin(admin_id) 
ON DELETE CASCADE
)*/

class Message {
    private $message_id;
    private $receiver_id;
    private $sender_id;
    private $message_text;
    private $message_title;
    private $creationDate; 
    private $name; 
    private $surname;
    private $admin_name;
    
   
    public function __construct($receiver_id = 0, $sender_id = 0, 
            $message_text = "", $message_title = "", $creationDate = ""){ 

        $this->id = -1;
        $this->setReceiverId($receiver_id);
        $this->setSenderId($sender_id);
        $this->setMessageText($message_text); 
        $this->setMessageTitle($message_title); 
        $this->setCreationDate($creationDate);
    }
    
    
    
   
    public function setMessageId($newMessageId) {
        if (is_numeric($newMessageId)) {
            $this->id = $newMessageId;
        }
    } 
    
    public function setReceiverId($newReceiverId) {
        if (is_numeric($newReceiverId)) {
            $this->receiver_id = $newReceiverId;
        }
    } 
    public function setSenderId($newSenderId) {
        if (is_numeric($newSenderId)) {
            $this->sender_id = $newSenderId;
        }
      
    } 
    public function setMessageText($newMessageText) {
        if (is_string($newMessageText)) {
            $this->message_text = $newTextMessage;
        }
    } 
     public function setMessageTitle($newMessageTitle) {
        if (is_string($newMessageTitle) && strlen($newMessageTitle) > 0) {
            $this->message_title = $newMessageTitle;
        } 
     } 
     public function setCreationDate($newCreationDate) {
        if (is_integer($newCreationDate)) {
            $this->creationDate = $newCreationDate;
        }
    }
     
    public function getMessageId() {
        return $this->message_id;
    }
    
    public function getReceiverId() {
        return $this->receiver_id;
    }
    
    public function getSenderId() {
        return $this->sender_id;
    }
    
    public function getMessageText() {
        return $this->message_text;
    }
   
    public function getMessageTitle() {
        return $this->message_title;
    }
    
    public function getCreationDate() {
        return $this->creationDate;
    } 
    
    
// zpaisywanie do bazy podczas wysyłania - funkcja dla admina
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $sql = "INSERT INTO Message(receiver_id, sender_id ,message_text,message_title,creationDate)
                   VALUES ('$this->receiver_id', '$this->sender_id',"
                    . " '$this->message_text', '$this->message_title', '$this->creationDate')";
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = $conn->insert_id;
                return true;
            } else {
                return false;
            }
        }
    }
      // wyświatlanie przez usera
    static public function loadMessagesByReceiverId(mysqli $conn, $receiver_id) {
        $sql = "SELECT Message.message_id,sender_id,message_text,message_title,creationDate,admin_name
                FROM Message Join Admin ON
                Admin.admin_id = Message.sender_id
                WHERE receiver_id = $receiver_id ORDER BY creationDate DESC";
        $ret = [];
        $result = $conn->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->message_id = $row['id'];
                $loadedMessage->sender_id = $row['sender_id']; 
                $loadedMessage->message_text = $row['message_text'];
                $loadedMessage->message_title = $row['message_title'];
                $loadedMessage->creationDate = $row['creationDate']; 
                $loadedMessage->admin_name = $row['admin_name'];
                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }
// funkcja dla admina- wyświatla wysłane wiadomości
    static public function loadMessagesBySenderId(mysqli $conn, $sender_id) {
        $sql = "SELECT Message.message_id,receiver_id,message_text,message_title,creationDate,name,surname
                FROM Message Join User ON
                User.id = Message.receiver_id
                WHERE sender_id = $sender_id ORDER BY creationDate DESC";
        
        $ret = [];
        $result = $conn->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->receiver_id = $row['receiver_id'];
                $loadedMessage->message_text = $row['message_text'];
                $loadedMessage->message_title = $row['message_title'];
                $loadedMessage->creationDate = $row['creation_date']; 
                $loadedMessage->name = $row['name']; 
                $loadedMessage->surname = $row['surname'];
                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }   
    // wyswietlenie pojedynczej wiadomości- dla admina i usera
    static public function loadMessageById(mysqli $conn, $message_id){
        $sql = "SELECT * FROM Message WHERE message_id=$message_id";
        $result = $conn->query($sql); 
    
        if($result == true && $result->num_rows == 1){
            $row = $result->fetch_assoc();
            $loadedMessage = new Message();
            $loadedMessage->message_id = $row['message_id'];
            $loadedMessage->receiver_id = $row['receiver_id']; 
            $loadedMessage->sender_id = $row['sender_id']; 
            $loadedMessage->message_text = $row['message_text'];
            $loadedMessage->message_title = $row['message_title'];
            $loadedMessage->creationDate = $row['creation_date']; 
            return $loadedMessage;
        }
        return null; 
  }
}
