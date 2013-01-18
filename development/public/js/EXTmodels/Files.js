Ext.define('Files', {
            extend: 'Ext.data.Model',
            fields: [
{ name: 'id' , type: 'numberfield' },
{ name: 'parent_id' , type: 'numberfield' },
{ name: 'text' , type: 'textfield' },
{ name: 'extension' , type: 'textfield' },
{ name: 'leaf' , type: 'numberfield' }] } )