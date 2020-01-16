<?php

    class UsersController extends AppController {

        public function index() {
            // $this->redirect('index');
        }

        // Create new user / registration
        public function create() {

            $this->request->trustProxy = true;
            $clientIp = $this->request-> clientIp();

            if(!empty($this->data)) {
                
                $this->User->set(array(
                    'created_ip' => $clientIp,
                    'modified_ip' => $clientIp
                ));

                if($this->User->save($this->data)) {
                    $this->Session->setFlash('Registration successful. You can login using your registered account.');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
                else {
                    $this->Session->setFlash('Registration unsuccessful. Please try again!');
                }
            }
        }

        public function login($email = null, $password = null){
            $auth = $this->User->find('first', array('and' => array('User.email' => $email, 'User.password' => $password)));
            if(!empty($auth)){
                $this->Session->setFlash('Exist');
                $this->redirect('../messages/index');
            }
            else{
                $this->Session->setFlash('Succ');
            }
            // if($this->User->find('first',  array(
            //     'AND' => array(
            //         'User.email' => $email = null, 
            //         'User.password' => $password = null
            //         )
            //     )
            // )){
            //     $this->Session->setFlash('Successfully logged ');
            //     $this->redirect('../messages/index');
            // }
            // else{
            //     $this->Session->setFlash('Login failed');
            // }
        }
    }

?>