<script>
Ext.require(['Ext.data.*', 'Ext.grid.*']);

<?php echo File::get( path('public') . 'js/EXTmodels/'.$model .'.js' ); //including Ext model ?>

Ext.onReady(function(){

    var store = Ext.create('Ext.data.Store', {
        autoLoad: true,
        autoSync: true,
        model: '<?php echo $model ?>',                                       
        proxy: {
            type: 'rest',
            url: '<?php echo Str::lower($model) . 'grid' ?>',              
            reader: {
                type: 'json',
                root: 'data'
            },
            writer: {
                type: 'json'
            }
        }
    });
    
    var rowEditing = Ext.create('Ext.grid.plugin.RowEditing');
    
    var grid = Ext.create('Ext.grid.Panel', {
        renderTo: document.body,
        plugins: [rowEditing],
        width: 500,
        height: 350,
        frame: true,
        title: 'List of <?php echo $model?>',
        store: store,
        iconCls: 'icon-user',
        columns: [
            <?php  
            $columns = Cache::get('ext'.$model );
            foreach ($columns as $column)
            {
              if ($column->field == 'id') continue;
             echo " { header: '".$column->field . '\',';
             echo " dataIndex: '".$column->field . '\',';
             echo "editor: {
                    xtype: 'textfield',
                    allowBlank: true
                },
                flex: 1
            },";
            }
            
            ?>
            ],
        dockedItems: [{
            xtype: 'toolbar',
            items: [{
                text: 'Add',
                iconCls: 'icon-add',
                handler: function(){
                    rowEditing.cancelEdit();
                    var newRecord = new <?php echo $model.'()' ?> 

                    store.insert(0, newRecord);
                    rowEditing.startEdit(0, 0);

                    var sm = grid.getSelectionModel();

                }
            }, '-', {
                text: 'Delete',
                iconCls: 'icon-delete',
                handler: function(){
                    var selection = grid.getView().getSelectionModel().getSelection()[0];
                    if (selection) {
                        store.remove(selection);
                    }
                }
            }]
        }]
    });
});

</script>
