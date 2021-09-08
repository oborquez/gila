<?php 

class Login {

    private $username;
    private $password;
    private $token;
    protected $users = array(
        [
            'username' => 'user1',
            'password' => 'PassUsr1',
            'token' => '1rsUssaP'
        ],
        [
            'username' => 'user2',
            'password' => 'PassUsr2',
            'token' => '2rsUssaP'
        ],
        [
            'username' => 'user3',
            'password' => 'PassUsr3',
            'token' => '3rsUssaP'
        ]

    );

    public function __construct($username, $password, $token) {
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
    }

    public function tryToLog(){
        
        
        foreach($this->users as $k=>$user)
            if($user["username"] == $this->username && $user["password"] == $this->password)
                return  $this->users[$k];
        return false;

    }
    public function isLoged( ){
            
       foreach( $this->users as $k=>$user)
            if($this->token == $user['token'])
                return  $this->users[$k];
       return false;
        
    }

}