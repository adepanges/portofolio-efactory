Ext.define("FACTORY.modules.master.App", {
	extend: "Ext.panel.Panel",
	alternateClassName: "FACTORY.master",
	alias: 'widget.content_master',
	initComponent: function() {
		var me = this;
		Ext.apply(me, {
			layout: 'card',
			tbar: [{
				text: 'Master Mesin',
				handler: function() {
					var obj = me.getLayout();
					obj.setActiveItem('master_mesin');
				}
			}, {
				text: 'Master Downtime',
				handler: function() {
					var obj = me.getLayout();
					obj.setActiveItem('master_downtime');
				}
			}, {
				text: 'Master Produk',
				handler: function() {
					var obj = me.getLayout();
					obj.setActiveItem('master_product');
				}
			}, {
				text: 'Master User',
				handler: function() {
					var obj = me.getLayout();
					obj.setActiveItem('master_user');
				}
			},'->',
			{
				text: 'Supervisor Page',
				handler: function(){
					window.location = app.SITE_URL+'/supervisor';
				}
			},
			{
				text: 'Keluar',
				handler: function(){
					window.location = app.SITE_URL+'/log/out';
				}
			}],
			items: [{
				xtype: 'daftar_mesin',
				title: 'Master Mesin',
				itemId: 'master_mesin'
			}, {
				xtype: 'daftar_downtime',
				title: 'Master Downtime',
				itemId: 'master_downtime'
			}, {
				xtype: 'daftar_product',
				title: 'Master Produk',
				itemId: 'master_product'
			}, {
				xtype: 'daftar_user',
				title: 'Master User',
				itemId: 'master_user'
			}]
		});
		me.callParent([arguments]);
	}
});