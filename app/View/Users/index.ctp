<h2>Login</h2>
<?php
    echo $this->Form->create('User', array('url' => 'login'));
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->end('Login');
    echo $this->Form->postLink('No account yet? CREATE ACCOUNT HERE', array(
        'action' => 'create'
    ));
?>