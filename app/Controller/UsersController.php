<?php

    class UsersController extends AppController {

        // Access to pages even that dont require login
        public function beforeFilter() {
            $this->Auth->allow(array('create'));
            
            // Check if already logged in
            if (in_array($this->request->action, ['login', 'create']) && !empty($this->Auth->user('id'))) {
                $this->Session->setFlash('Permission denied! You are already logged in');
                $this->redirect($this->Auth->redirectUrl());
            }
        }

        public function create() {
            
            // Still not working
            $this->request->trustProxy = true;
            $clientIp = $this->request-> clientIp();

            if(!empty($this->data)) {
                
                $this->User->set(array(
                    'created_ip' => $clientIp,
                    'modified_ip' => $clientIp
                ));
                
                $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);

                if($this->User->save($this->data)) {
                    $this->Session->setFlash('Registration successful. You can login using your registered account.');
                    $this->redirect(array(
                        'action' => 'login'
                    ));
                }
                else {
                    $this->Session->setFlash('Registration unsuccessful. Please try again!');
                }
            }
        }

        public function login(){
            if($this->request->is('post')){
                if(!empty($this->request->data)){

                    // AuthComponent predefined login
                    if($this->Auth->login(array())){
    
                        $this->User->id = $this->Auth->user('id');
                        $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));
    
                        return $this->redirect($this->Auth->loginRedirect);
                    }
                    else{
                        $this->Session->setFlash('Invalid username or password');
                    }
                }
            }
        }

        public function logout() {
            $this->redirect($this->Auth->logout());
        }

        public function profile($id) {
            $this->set('details', $this->User->findById($id));
        }

        public function edit($id) {
            $this->set('details', $this->User->findById($id));
        }

        public function update() {
            if ($this->request->is('post')) {
                if(!empty($this->request->data['User']['file']['name'])){
                    $filename = $this->request->data['User']['file']['name'];
                    $filepath = $_SERVER['DOCUMENT_ROOT'] . '/messenger/app/webroot/img/' . $this->request->data['User']['file']['name'];

                    if(move_uploaded_file($this->request->data['User']['file']['tmp_name'], $filepath)){

                        $this->User->id = $this->Auth->user('id');
                        $data = $this->User->saveField('image', $filename);

                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'profile', $this->Auth->user('id')
                        ));
                        $this->Flash->success('Upload file successful');
                    }
                    else{
                        $this->Flash->error('Unable to upload file, please try again.');
                    }
                    // $uploadPath = 'uploads/files/';
                    // $uploadFile = $uploadPath.$fileName;
                    // if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    //     $uploadData = $this->Files->newEntity();
                    //     $uploadData->name = $fileName;
                    //     $uploadData->path = $uploadPath;
                    //     $uploadData->created = date("Y-m-d H:i:s");
                    //     $uploadData->modified = date("Y-m-d H:i:s");
                    //     if ($this->Files->save($uploadData)) {
                    //         $this->Flash->success(__('File has been uploaded and inserted successfully.'));
                    //     }else{
                    //         $this->Flash->error(__('Unable to upload file, please try again.'));
                    //     }
                    
                }else{
                    $this->Flash->error('Please choose a file to upload.');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'edit', $this->Auth->user('id')
                    ));
                }
                
            }
            // if($this->request->is('post')){
            //     if(!empty($this->request->data['file']['name'])){
            //         $filename = $this->request->data['file']['name'];
            //         print_r($filename);
            //         exit();
            //     }
            //     else{
            //         $this->Session->setFlash('Please choose a file to upload');
            //     }
            // }
        }
    }

?>