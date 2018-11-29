Ext.define("FACTORY.modules.master.daftar_product", {
	extend: "Ext.grid.Panel",
	alternateClassName: "FACTORY.daftar_product",
	alias: 'widget.daftar_product',
	initComponent: function() {
		var me = this;
		Ext.apply(me, {
			width: 300,
			border: 0,
			store: Ext.create('Ext.data.Store', {
				storeId: 'productStore',
				fields: ['id_product', 'product_name', 'duration', 'active'],
				autoLoad: true,
				proxy: {
					type: 'ajax',
					url: app.SITE_URL + '/admin/master/product/get',
					actionMethods: {
						create: 'POST',
						read: 'POST',
						update: 'POST',
						destroy: 'POST'
					},
					reader: {
						type: 'json',
						rootProperty: 'data'
					}
				}
			}),
			listeners: {
				cellclick: function(th, td, cellIndex, record, tr, rowIndex, e, eOpts) {

				}
			},
			columns: [{
				xtype: 'rownumberer',
				'header': 'No',
				width: 30
			}, {
				header: 'Nama Produk',
				dataIndex: 'product_name',
				flex: 3
			}, {
				header: 'Durasi Produksi',
				dataIndex: 'duration',
				flex: 3,
				renderer: function(v){
					return v+' Menit';
				}
			}, {
				header: 'Status',
				dataIndex: 'active',
				flex: 1,
				renderer: function(v) {
					var out = '';
					if (parseInt(v) == 1) {
						out = 'Aktif';
					} else if (parseInt(v) == 0) {
						out = 'Nonaktif';
					}
					return out;
				}
			}],
			tbar: ['->', {
				text: 'Tambah',
				handler: function() {
					me.onTambahUbah(1);
				}
			}, {
				text: 'Ubah',
				handler: function() {
					data = me.getSelectionModel().getSelection();
					if (data.length > 0) {
						me.onTambahUbah(2);
					} else {
						Ext.Msg.alert('Pesan', 'Pilih data terlebih dahulu');
					}
				}
			}, {
				text: 'Hapus',
				handler: function() {
					data = me.getSelectionModel().getSelection();
					if (data.length > 0) {
						me.onHapus(data[0]);
					} else {
						Ext.Msg.alert('Pesan', 'Pilih data terlebih dahulu');
					}
				}
			}],
			dockedItems: [{
				xtype: 'pagingtoolbar',
				store: 'productStore',
				dock: 'bottom',
				displayInfo: true
			}]
		});
		me.callParent([arguments]);
	},
	onHapus: function(data) {
		me = this;
		Ext.Msg.show({
			title: 'Yakin?',
			message: 'Apakah anda yakin akan menghapus data ini?',
			buttons: Ext.Msg.YESNO,
			icon: Ext.Msg.QUESTION,
			fn: function(btn) {
				if (btn === 'yes') {
					Ext.Ajax.request({
						url: app.SITE_URL + '/admin/master/product/del',
						params: {
							id_product: data.get('id_product')
						},
						success: function(response) {
							var res = Ext.decode(response.responseText);
							Ext.Msg.alert('Pesan', res.msg);
							me.getStore().load();
						},
						failure: function() {
							Ext.Msg.alert('Pesan', 'Ada masalah dengan jaringan');
						}
					});
				}

			}

		});
	},
	onTambahUbah: function(flag) {
		me = this;
		title = '';
		if (flag == 1) {
			title = 'Tambah';
		} else if (flag == 2) {
			title = 'Ubah';
		}
		Ext.getBody().mask();

		windowForm = Ext.create('Ext.window.Window', {
			title: title,
			width: 400,
			layout: 'fit',
			resizable: false,
			closeAction: 'destroy',
			items: [{
				xtype: 'form',
				itemId: 'formProduct',
				style: {
					padding: '5px'
				},
				url: app.SITE_URL + '/admin/master/product/simpan',
				layout: 'anchor',
				defaults: {
					width: '98%',
					lebelWidth: 100,
					style: {
						margin: '3px'
					}
				},
				defaultType: 'textfield',
				items: [{
					xtype: 'hiddenfield',
					name: 'id_product'
				}, {
					fieldLabel: 'Nama Mesin',
					name: 'product_name',
					allowBlank: false
				}, {
					fieldLabel: 'Durasi Produksi',
					name: 'duration',
					allowBlank: false
				}, {
					xtype: 'radiogroup',
					fieldLabel: 'Status',
					columns: 2,
					vertical: true,
					items: [{
						boxLabel: 'Aktif',
						name: 'active',
						inputValue: '1'
					}, {
						boxLabel: 'Nonaktif',
						name: 'active',
						inputValue: '0'
					}]
				}]
			}],
			bbar: ['->', {
				text: 'Simpan',
				handler: function() {
					formProduct = windowForm.down('#formProduct').getForm();
					if (formProduct.isValid()) {
						formProduct.submit({
							success: function(form, action) {
								Ext.Msg.alert('Success', action.result.msg);
								me.getStore().load();
								windowForm.destroy();
							},
							failure: function(form, action) {
								switch (action.failureType) {
									case Ext.form.action.Action.CLIENT_INVALID:
										Ext.Msg.alert('Failure', 'Form fields may not be submitted with invalid values');
										break;
									case Ext.form.action.Action.CONNECT_FAILURE:
										Ext.Msg.alert('Failure', 'Ajax communication failed');
										break;
									case Ext.form.action.Action.SERVER_INVALID:
										Ext.Msg.alert('Failure', action.result.msg);
								}
							}
						});
					} else {
						Ext.Msg.alert('Pesan', 'Lengkapi data terlebih dahulu');
					}
				}
			}, {
				text: 'Batal',
				handler: function() {
					windowForm.destroy();
				}
			}, '->'],
			listeners: {
				'destroy': function() {
					Ext.getBody().unmask();
				}
			}
		});

		formProduct = windowForm.down('#formProduct').getForm();
		if (flag == 2) {
			data = me.getSelectionModel().getSelection()[0];
			formProduct.loadRecord(data);
		}

		windowForm.show();
	}
});