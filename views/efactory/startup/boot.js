function startup(){
	if(Ext.isEmpty(app.BASE_URL)){
		alert("Error!!","Please set a correct value for the 'pangestu.BASE_URL' constant!");
		return;
	}

	Ext.Loader.setConfig({ 
		enabled : true, 
		paths : { 
			Ext :app.EXT_URL,
			FACTORY :app.FACTORY_URL
		} 
	});

	// Ext.require("Ext.History");

	Ext.require("FACTORY.modules.master.App");
	Ext.require("FACTORY.modules.master.daftar_downtime");
	Ext.require("FACTORY.modules.master.daftar_mesin");
	Ext.require("FACTORY.modules.master.daftar_product");
	Ext.require("FACTORY.modules.master.daftar_user");
}