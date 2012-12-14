Ext.define('AM.view.user.List' ,  {
    extend: 'Ext.grid.Panel',
    alias: 'widget.userlist',
    title: 'All Users',
    store: 'Users',
	
	initComponent: function() {
        this.columns = [
            {   header: 'Id',  dataIndex: 'id',  flex: 1 },
            {   header: 'Login', dataIndex: 'login', flex: 1 },
            {   header: 'Password', dataIndex: 'password', flex: 1 },
            {   header: 'Private', dataIndex: 'private', flex: 1 }
        ];

        this.callParent(arguments);
    }
});
