<?php
/**
 * This classe is used as an interface for model classes.
 *
 * @author  samuelrcosta
 * @version 0.1.0, 10/10/2017
 * @since   0.1
 */
class Model{

    /**
     * The object for database controls.
     */
    protected $db;

    /**
     * The data for the email connection.
     */
    protected $MailHost;
    protected $MailPort;
    protected $MailSecurity;
    protected $MailUsername;
    protected $MailPassword;
    protected $MailName;
    protected $MAILCHIMP_API_KEY;
    protected $MAILCHIMP_LIST_ID;

    /**
     * The constructor for models.
     */
    public function __construct(){
        global $db;
        global $MailHost;
        global $MailPort;
        global $MailSecurity;
        global $MailUsername;
        global $MailPassword;
        global $MailName;
        global $MAILCHIMP_API_KEY;
        global $MAILCHIMP_LIST_ID;

        $this->db = $db;
        $this->MailHost = $MailHost;
        $this->MailPort = $MailPort;
        $this->MailSecurity = $MailSecurity;
        $this->MailUsername = $MailUsername;
        $this->MailPassword = $MailPassword;
        $this->MailName = $MailName;
        $this->MAILCHIMP_API_KEY = $MAILCHIMP_API_KEY;
        $this->MAILCHIMP_LIST_ID = $MAILCHIMP_LIST_ID;
    }
}