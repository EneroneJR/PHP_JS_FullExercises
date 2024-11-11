<?php
class RequestBody{
    public $username;
    public $password;
    public $client_id;
    public $client_secret;
    public $grant_type;
    public $response_type;

    function __construct()
    {
        $this->username = "test";
        $this->password = "Area Testing";
        $this->client_id = "nemesiApiClient";
        $this->client_secret = "n3m3s1!Secret";
        $this->grant_type = "password";
        $this->response_type = "code";
    }
}
?>