<?php

    App::uses('User', 'Model');
    App::uses('Message', 'Model');

    class MessagesController extends AppController {

        public function index() {
            $user = new User();
            $users = $user->find('all');
            $this->set('users', $users);
        }

        public function send($id = NULL) {

            $this->request->trustProxy = true;
            $clientIp = $this->request-> clientIp();

            $messages = $this->Message->find('all', array(
                'OR' => array(
                    'Message.from_id' => 1,
                    'Message.to_id' => 1
                ),
                'order' => array(
                    'created' => 'asc'
                ),
                'limit' => 10,
                'offset' => 0
            ));

            if(!empty($this->data)) {
                $this->Message->set(array(
                    'to_id' => 2,
                    'from_id' => 1,
                    'created_ip' => $clientIp,
                    'modified_ip' => $clientIp
                ));

                if($this->Message->save($this->data)) {
                    $this->redirect('send')->set('messages', $messages);
                    $this->Session->setFlash('Message sent.');
                }
                else {
                    $this->Session->setFlash('Sending message failed');
                }
            }
            else{
                $this->set('messages', $messages);
            }
        }

    }

?>