<h2>Message List</h2>
<?php

    echo $this->Form->create('Message');
    echo $this->Form->input('content');
    echo $this->Form->end('Send Messsage');
    
    foreach($messages as $message) :
        if($message['Message']['from_id'] == 1){
            echo '
                <div class="container darker">
                    '.$this->Html->image('unknown.jpeg', array(
                        'class' => 'right'
                    )).'
                    <p class="float-right">'.$message['Message']['content'].'</p>
                    <span class="time-right">'.$message['Message']['created'].' - (you)</span>
                </div>
            ';
        }
        else{
            echo '
                <div class="container">
                    '.$this->Html->image('unknown.jpeg').'
                    <p>'.$message['Message']['content'].'</p>
                    <span>'.$message['Message']['created'].' -
                    '.$this->Form->postLink('Delete').'</span>
                </div>
            ';
        }
    endforeach;

?>