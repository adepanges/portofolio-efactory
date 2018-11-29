Ext.define("FACTORY.modules.master.daftar_user", {
	extend: "Ext.grid.Panel",
	alternateClassName: "FACTORY.daftar_user",
	alias: 'widget.daftar_user',
	initComponent: function() {
		var me = this;
		Ext.apply(me, {
			width: 300,
			border: 0,
			store: Ext.create('Ext.data.Store', {
				storeId: 'userStore',
				fields: ['id_user', 'username', 'password', 'nama', 'id_hakakses', 'nama_hakakses'],
				autoLoad: true,
				proxy: {
					type: 'ajax',
					url: app.SITE_URL + '/admin/master/user/get',
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
				header: 'Username',
				dataIndex: 'username',
				flex: 1
			}, {
				header: 'Nama User',
				dataIndex: 'nama',
				flex: 3
			}, {
				header: 'Hak Akses',
				dataIndex: 'nama_hakakses',
				flex: 3
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
				store: 'userStore',
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
						url: app.SITE_URL + '/admin/master/user/del',
						params: {
							id_problem: data.get('id_problem')
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
				itemId: 'formUser',
				style: {
					padding: '5px'
				},
				url: app.SITE_URL + '/admin/master/user/simpan',
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
					name: 'id_user'
				}, {
					fieldLabel: 'Username',
					name: 'username',
					allowBlank: false
				}, {
					fieldLabel: 'Password',
					inputType: 'password',
					name: 'password',
					allowBlank: false
				}, {
					fieldLabel: 'Nama',
					name: 'nama'
				}, {
					xtype: 'radiogroup',
					fieldLabel: 'Hak Akses',
					columns: 2,
					vertical: true,
					allowBlank: false,
					items: [{
						boxLabel: 'Admininistrator',
						name: 'id_hakakses',
						inputValue: '1'
					}, {
						boxLabel: 'Supervisor',
						name: 'id_hakakses',
						inputValue: '2'
					}, {
						boxLabel: 'Operator',
						name: 'id_hakakses',
						inputValue: '3'
					}]
				}]
			}],
			bbar: ['->', {
				text: 'Simpan',
				handler: function() {
					formUser = windowForm.down('#formUser').getForm();
					if (formUser.isValid()) {
						formUser.submit({
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

		formUser = windowForm.down('#formUser').getForm();
		if (flag == 2) {
			data = me.getSelectionModel().getSelection()[0];
			formUser.loadRecord(data);
		}

		windowForm.show();
	}
});