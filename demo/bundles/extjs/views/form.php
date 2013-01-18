<script>
    Ext.onReady( function() {
Ext.create('Ext.form.Panel', {
    renderTo: Ext.getBody(),
    url: 'update_<?php echo strtolower($model) ?>',
    title: '<?php echo $model ?> Form',   
    height: 200,
    width: 300,
    bodyPadding: 10,
    buttons: [
        {
            text: 'Submit',
            handler: function() {
                var form = this.up('form').getForm(); 
                if (form.isValid()) { 
                    form.submit({
                        success: function(form, action) {
                           Ext.Msg.alert('Success', action.result.msg);
                        },
                        failure: function(form, action) {
                            Ext.Msg.alert('Failed', action.result.msg);
                        }
                    });
                } else { 
                    Ext.Msg.alert('Invalid Data', 'Please correct form errors.')
                }
            }
        }
    ],
    //defaultType: 'textfield',
    items: [   
    <?php
        $columns = Cache::get('ext'.$model ); 
        $iteration = 0;
        foreach ($columns as $column)
        {
            if ($column->field == 'id' ) continue;
            if ($iteration) echo ',';
            $type = lext::getExtType($column->field);
            
            echo "{
            fieldLabel: '".lext::text($column->field) ."',
            name: '$column->field',
            xtype: '$type',
            } ";
            $iteration++;
        }
    ?>
    ]
});

});


</script>

