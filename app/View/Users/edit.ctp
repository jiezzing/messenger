<h1>Upload File</h1>
<div class="content">
    <div>
        <?php 
            foreach($details as $detail){
                echo $this->Form->create('User', [
                    'type' => 'file', 
                    'url' => 'update', 
                    'controller' => 'users'
                ]); 
                if($detail['image'] == null){
                    echo $this->Html->image('unknown.jpeg', [
                        'height' => '300',
                        'alt' => 'unknown'
                    ]);
                }
                else{
                    echo $this->Html->image($detail['image'], [
                        'height' => '300',
                        'alt' => $detail['image']
                    ]);
                }
                echo $this->Form->input('file', [
                    'type' => 'file', 
                    'accept' => '.jpg, .png, .gif'
                    ]);
                echo $this->Form->input('name', ['value' => $detail['name']]);

                $options = [
                    'M' => 'Male', 
                    'F' => 'Female'
                ];
                $attributes = [
                    'legend' => false,
                    'default' => 'M'
                ];

                echo $this->Form->radio('gender', $options, $attributes);
                echo $this->Form->input('body', ['value' => $detail['hubby']]);
                echo $this->Form->button('Save Changes', [
                    'type' => 'submit'
                ]); 
                echo $this->Form->end();
            }
        ?>
    </div>