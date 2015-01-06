<?php

// Author: Sergey Stalev
// Enable extension in php.ini: extension=php_imap.dll
// List of mail servers: http://www.arclab.com/products/amlc/list-of-smtp-and-imap-servers-mailserver-list.html
// Gmail and yahoo mail API
class MAIL_API {
    protected
            $hostname = '',
            $username = '',
            $password = '';

    private
            $inbox = null,
            $emails = null,
            $emailsArray = array();

    public function __construct($username = null, $password = null) {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    public function __destruct() {
        $this->closeConnection();
    }

    public function setHostname($hostname = null) {
        if (isset($hostname) && strlen(trim($hostname))) {
            $this->hostname = $hostname;
        }
    }

    public function setUsername($username = null) {
        if (isset($username) && strlen(trim($username))) {
            $this->username = $username;
        }
    }

    public function setPassword($password = null) {
        if (isset($password) && strlen(trim($password))) {
            $this->password = $password;
        }
    }

    public function init($param = 'ALL') {
        if ($this->connectToMailServer()) {
            if ($param == 'ALL') {
                $mailDirectories = imap_list($this->inbox, $this->hostname, '*');

                if (!count($mailDirectories) || !$mailDirectories || is_bool($mailDirectories)) return true;

                foreach ($mailDirectories as $mailDirectory) {
                    if (imap_reopen($this->inbox, $mailDirectory)) {
                        $this->grabEmails();
                        $this->getEmails(3);
                    }
                }
            }
            elseif ($param == 'SINGLE') {
                $this->grabEmails();
                $this->getEmails(3);
            }

            $this->closeConnection();

            return true;
        }
        else {
            return false;
        }
    }

    public function getEmailsArray($doImplode = false) {
        if ($doImplode) {
            return implode('', $this->emailsArray);
        }
        else {
            return $this->emailsArray;
        }
    }

    public function connectToMailServer() {
        $this->inbox = @imap_open($this->hostname, $this->username, $this->password);

        if (!$this->inbox)
        {
            //imap_last_error()
            return false;
        }

        return true;
    }

    public function closeConnection() {
        if ($this->inbox) {
            @imap_close($this->inbox);
        }
    }

    /**
      ALL - return all messages matching the rest of the criteria
      ANSWERED - match messages with the \\ANSWERED flag set
      BCC "string" - match messages with "string" in the Bcc: field
      BEFORE "date" - match messages with Date: before "date"
      BODY "string" - match messages with "string" in the body of the message
      CC "string" - match messages with "string" in the Cc: field
      DELETED - match deleted messages
      FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
      FROM "string" - match messages with "string" in the From: field
      KEYWORD "string" - match messages with "string" as a keyword
      NEW - match new messages
      OLD - match old messages
      ON "date" - match messages with Date: matching "date"
      RECENT - match messages with the \\RECENT flag set
      SEEN - match messages that have been read (the \\SEEN flag is set)
      SINCE "date" - match messages with Date: after "date"
      SUBJECT "string" - match messages with "string" in the Subject:
      TEXT "string" - match messages with text "string"
      TO "string" - match messages with "string" in the To:
      UNANSWERED - match messages that have not been answered
      UNDELETED - match messages that are not deleted
      UNFLAGGED - match messages that are not flagged
      UNKEYWORD "string" - match messages that do not have the keyword "string"
      UNSEEN - match messages which have not been read yet
     */
    public function grabEmails($param = 'ALL') {
        $this->emails = imap_search($this->inbox, $param);

        if (is_array($this->emails) && count($this->emails)) {
            rsort($this->emails);
        }
    }

    public function getEmails($getEmailsType = 1) {
        if (is_array($this->emails) && count($this->emails)) {
            $output = array();

            foreach ($this->emails as $email) {
                // get the mail information
                $overview = imap_fetch_overview($this->inbox, $email, 0);
                //$message = imap_fetchbody($this->inbox, $email, 2);

                /* output the email header information
                  $output .= ($overview[0]->seen ? 'read' : 'unread');
                  $output .= $overview[0]->subject;
                  $output .= $overview[0]->date;
                  $output .= $message;
                  $output .= $overview[0]->from;
                 */


                if ($getEmailsType == 1) {
                    // From
                    if (preg_match("/<(.+)>/", $overview[0]->from, $matches)) {
                        if (is_array($matches)) {
                            if (isset($matches[1])) {
                                if (!in_array($matches[1], $this->emailsArray) && $matches[1] != $this->username) {
                                    $this->emailsArray[$matches[1]] = $matches[1];
                                }
                            } elseif (isset($matches[0])) {
                                if (!in_array($matches[0], $this->emailsArray) && $matches[0] != $this->username) {
                                    $this->emailsArray[$matches[0]] = $matches[0];
                                }
                            }
                        }
                    } else {
                        if (!in_array($overview[0]->from, $this->emailsArray) && $overview[0]->from != $this->username) {
                            $this->emailsArray[$overview[0]->from] = $overview[0]->from;
                        }
                    }


                    if (isset($overview[0]) && isset($overview[0]->to)) {
                        // To
                        if (preg_match("/<(.+)>/", $overview[0]->to, $matches)) {
                            if (is_array($matches)) {
                                if (isset($matches[1])) {
                                    if (!in_array($matches[1], $this->emailsArray) && $matches[1] != $this->username) {
                                        $this->emailsArray[$matches[1]] = $matches[1];
                                    }
                                } elseif (isset($matches[0])) {
                                    if (!in_array($matches[0], $this->emailsArray) && $matches[0] != $this->username) {
                                        $this->emailsArray[$matches[0]] = $matches[0];
                                    }
                                }
                            }
                        } else {
                            if (!in_array($overview[0]->to, $this->emailsArray) && $overview[0]->to != $this->username) {
                                $this->emailsArray[$overview[0]->to] = $overview[0]->to;
                            }
                        }
                    }
                }
                elseif ($getEmailsType == 2) {
                    if (!in_array($overview[0]->from, $this->emailsArray) && stripos($overview[0]->from, $this->username) === false) {
                        $this->emailsArray[$overview[0]->from] = $overview[0]->from;
                    }

                    if (!in_array($overview[0]->to, $this->emailsArray) && stripos($overview[0]->to, $this->username) === false) {
                        $this->emailsArray[$overview[0]->to] = $overview[0]->to;
                    }
                }
                else {
                    // From
                    if (preg_match("/<(.+)>/", $overview[0]->from, $matches)) {
                        if (is_array($matches)) {
                            if (isset($matches[1])) {
                                if (!in_array($matches[1], $this->emailsArray) && $matches[1] != $this->username) {
                                    $this->emailsArray[$matches[1]] = $overview[0]->from;
                                }
                            } elseif (isset($matches[0])) {
                                if (!in_array($matches[0], $this->emailsArray) && $matches[0] != $this->username) {
                                    $this->emailsArray[$matches[0]] = $overview[0]->from;
                                }
                            }
                        }
                    } else {
                        if (!in_array($overview[0]->from, $this->emailsArray) && $overview[0]->from != $this->username) {
                            $this->emailsArray[$overview[0]->from] = $overview[0]->from;
                        }
                    }

                    if (isset($overview[0]) && isset($overview[0]->to)) {
                        // To
                        if (preg_match("/<(.+)>/", $overview[0]->to, $matches)) {
                            if (is_array($matches)) {
                                if (isset($matches[1])) {
                                    if (!in_array($matches[1], $this->emailsArray) && $matches[1] != $this->username) {
                                        $this->emailsArray[$matches[1]] = $overview[0]->to;
                                    }
                                } elseif (isset($matches[0])) {
                                    if (!in_array($matches[0], $this->emailsArray) && $matches[0] != $this->username) {
                                        $this->emailsArray[$matches[0]] = $overview[0]->to;
                                    }
                                }
                            }
                        } else {
                            if (!in_array($overview[0]->to, $this->emailsArray) && $overview[0]->to != $this->username) {
                                $this->emailsArray[$overview[0]->to] = $overview[0]->to;
                            }
                        }
                    }
                }
            }
        }
        else {
            return false;
        }
    }

    public function toHtml($htmlPrefixIn = '<option>', $htmlPostfixIn = '</option>') {
        if (is_array($this->emailsArray) && count($this->emailsArray)) {
            $output = '';

            foreach ($this->emailsArray as $email) {
                $output = $this->pack($email, $output, $htmlPrefixIn, $htmlPostfixIn);
            }

            return $output;
        } else {
            return false;
        }
    }

    public function pack($value = null, $output = null, $htmlPrefixIn = '<option>', $htmlPostfixIn = '</option>') {
        // HTML
        if (isset($value) && $value) {
            $output = $output . $htmlPrefixIn . $value . $htmlPostfixIn;
        }

        return $output;
    }
}

final class G_mail extends MAIL_API {
    public function __construct() {
        //$this->setHostname('{imap.gmail.com:993/imap/ssl}');              // For all mbox folders - set 'ALL' parameter to init()
        $this->setHostname('{imap.gmail.com:993/ssl}[Gmail]/All Mail');     // For one mailbox folder - set 'SINGLE' parameter to init()
    }
}

final class Yahoo_mail extends MAIL_API {
    public function __construct() {
        $this->setHostname('{imap.mail.yahoo.com:993/imap/ssl}');         // For all mbox folders - set 'ALL' parameter to init()
        //$this->setHostname('{imap.mail.yahoo.com:993/imap/ssl}Bulk Mail');  // For one mailbox folder - set 'SINGLE' parameter to init()
    }
}

final class Abv_mail extends MAIL_API {
    public function __construct() {
        $this->setHostname('{pop3.abv.bg::995/pop/ssl}INBOX');              // For one mailbox folder - set 'SINGLE' parameter to init()
    }
}