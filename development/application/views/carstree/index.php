<?php $records =Cars::where('parent_id', '=', (int)$_GET['node'])->get() ?>
[
            <?php foreach($records as $record): ?>                      
                         
                                    {
                                    text: '<?php echo $record->text ?>',
                                    leaf: <?php if($record->leaf) echo 'true'; else echo 'false'; ?>,
                                    id: <?php echo $record->id ?>
                                     },
                                         
            <?php endforeach; ?>            
]