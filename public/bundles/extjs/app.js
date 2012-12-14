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
        },
        listeners: {
            write: function(store, operation){
                var record = operation.getRecords()[0],
                    name = Ext.String.capitalize(operation.action),
                    verb;
                    
                    
                if (name == 'Destroy') {
                    record = operation.records[0];
                    verb = 'Destroyed';
                } else {
                    verb = name + 'd';
                }
                Ext.example.msg(name, Ext.String.format("{0} user: {1}", verb, record.getId()));
                
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
                    store.insert(0, new Movies());
                    rowEditing.startEdit(0, 0);
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
