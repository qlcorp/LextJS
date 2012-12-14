<script>
Ext.require(['Ext.data.*', 'Ext.grid.*']);

Ext.define('Movies', {
    extend: 'Ext.data.Model',
    fields: [{
        name: 'title',
        type: 'string'
    }, 
    {
        name: 'year',
        type: 'int'
    }
    ]
});

Ext.onReady(function(){

    var store = Ext.create('Ext.data.Store', {
        autoLoad: true,
        autoSync: true,
        model: 'Movies',
        proxy: {
            type: 'rest',
            url: 'movies',
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
        width: 400,
        height: 300,
        frame: true,
        title: 'Movies list from DB',
        store: store,
        iconCls: 'icon-user',
        columns: [
            {
                header: 'Title',
                dataIndex: 'title',
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                },
                flex: 1
            },
            {
                header: 'Year',
                dataIndex: 'year',
                editor: {
                    xtype: 'numberfield',
                    allowBlank: true
                },
                flex: 1
            } ],
        dockedItems: [{
            xtype: 'toolbar',
            items: [{
                text: 'Add',
                iconCls: 'icon-add',
                handler: function(){
                    rowEditing.cancelEdit();
                    var newRecord = new Movies()

                    store.insert(0, newRecord);
                    rowEditing.startEdit(0, 0);

                    var sm = grid.getSelectionModel();

                    grid.on('edit', function() {
                        var record = sm.getSelection()[0]
                        //store.sync();
                        store.remove(record);
                        store.load();
                    });



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
