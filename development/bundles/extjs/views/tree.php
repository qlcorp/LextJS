<script>
Ext.onReady(function () {

    Ext.define('TreeCellEditing', {
        alias:'plugin.treecellediting',
        extend:'Ext.grid.plugin.CellEditing',

        init:function (tree) {
            var treecolumn = tree.headerCt.down('treecolumn');
            treecolumn.editor = treecolumn.editor || {xtype:'textfield'};

            this.callParent(arguments);
        },

        getEditingContext:function (record, columnHeader) {
            var me = this,
                    grid = me.grid,
                    store = grid.store,
                    rowIdx,
                    colIdx,
                    view = grid.getView(),
                    root = grid.getRootNode(),
                    value;

            if (Ext.isNumber(record)) {
                rowIdx = record;
                //record = store.getAt(rowIdx);
                record = root.getChildAt(rowIdx);
            } else {
                //rowIdx = store.indexOf(record);
                rowIdx = root.indexOf(record);
            }
            if (Ext.isNumber(columnHeader)) {
                colIdx = columnHeader;
                columnHeader = grid.headerCt.getHeaderAtIndex(colIdx);
            } else {
                colIdx = columnHeader.getIndex();
            }

            value = record.get(columnHeader.dataIndex);
            return {
                grid:grid,
                record:record,
                field:columnHeader.dataIndex,
                value:value,
                row:view.getNode(rowIdx),
                column:columnHeader,
                rowIdx:rowIdx,
                colIdx:colIdx
            };
        }
    });
//end of cell editing plugin

    var store = Ext.create('Ext.data.TreeStore', {
        fields:['text'],
        proxy:{
            type:'rest',       
            url:'<?php echo Str::lower($model) . 'nodes' ?>',
            reader:{
                type:'json',
                root:'data'
            },
            writer:{
                type:'json'
            }
        },
        autoLoad:true,
        autoSync:true,
        root:{
            text:'Ext JS',
            id:0,
            expanded:true
        }
    });

//var treeCellEditor = Ext.create('Sch.plugin.TreeCellEditing');
    var treeCellEditor = Ext.create('plugin.treecellediting', {
//    var treeCellEditor = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit:2
    });
    var tree = Ext.create('Ext.tree.Panel', {
        renderTo:Ext.getBody(),
        selType:'cellmodel',
        plugins:[ treeCellEditor ],
        title:'<?php echo $model ?> Tree',
        width:250,
        height:300,
        store:store,

        viewConfig:{
            plugins:{
                ptype:'treeviewdragdrop'
            }
        },

        dockedItems:[
            {
                xtype:'toolbar',
                items:[
                    {
                        text:'Add leaf',
                        iconCls:'icon-add',
                        handler:function () {
                            var record = tree.getSelectionModel().getSelection()[0];
                            record.appendChild({
                                text:'new leaf',
                                leaf:true,
                                parentId: record.id
                            });
                        }

                    },
                    '-',
                    {
                        text:'Add node',
                        handler:function () {
                            var record = tree.getSelectionModel().getSelection()[0];
                            record.appendChild({
                                text:'new node',
                                leaf:false,
                                parentId: record.id
                            });
                        }
                    },
                    '-' ,
                    {
                        text:'Delete',
                        iconCls:'icon-delete',
                        handler:function () {
                            var record = tree.getSelectionModel().getSelection()[0];
                            record.remove();
                        }
                    }
                ] //end of items
            }
        ]



    });

});
</script>
