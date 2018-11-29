<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Master Control</title>
        <script type="text/javascript">
        	app = <?php echo json_encode($app) ?>;
        </script>
        <script id="microloader" type="text/javascript" src="<?php echo $this->config->item('base_media') ?>ext-5.1.0/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>views/efactory/startup/boot.js"></script>
    </head>
    <body>
    	<script type="text/javascript">
    		startup();

    		Ext.onReady(function(){
    			var header = Ext.create('Ext.panel.Panel', {
					border:0,
					// bodyStyle:'background:#F1EFEEx !important;border:none; ',
					region:'north', id :'header',
					height : 'auto'
				});

				var center = Ext.create('Ext.panel.Panel', {
					id: 'center',
					region: 'center',
					border: 0,
					paddings: '0 0 0 0',
					layout: 'fit',
					items: [
						{
							xtype: 'content_master'
						}
					]
				});

				Ext.create('Ext.container.Viewport', {
					renderTo: Ext.getBody(),
					height:'100%',
					layout: 'border',
					items: [
						header,
						center
					]
				});

    		});
    	</script>
    </body>
</html>