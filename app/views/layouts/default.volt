<!DOCTYPE html>	
<html>
<head>
	<base href="{{ baseurl }}" />
	<meta charset="utf-8">
	{{ get_title() }}
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- FAVICONS -->
	<link rel="Shortcut icon" href="public/img/favicon.png" type="image/x-icon">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
	<!-- FONTAWESOME (needs to be loaded before body) -->
	<script defer src="js/vendor/fontawesome-all.min.js"></script>


	{{ assets.outputCss("header_styles") }}

	<!-- Add controller specific styles -->
	{% for collection_name, collection_object in assets.getCollections() %}
	{% if collection_name is controller_styles %}
	{{ assets.outputCss(collection_name) }}
	{% break %}
	{% endif %}
	{% endfor %}
	<!-- END controller specific styles -->

</head>
<body>
	<!-- NAV -->
	<!-- END NAV -->
	<div id='main' role='main'>

		<!-- MAIN CONTENT -->
		<div id='content'>
			<div class="container"></div>
				<div class="row">
				</div>
			</div>
			{{ content() }}
		</div>
		<!-- END MAIN CONTENT -->

	</div>

	<!-- FOOTER -->
	
    
	
	<!-- END FOOTER -->

	<!-- Global Definitions -->
	<script type='text/javascript'>
		var siteData = {
			baseurl: '{{ baseurl }}',
			adminurl: '{{ admin_url }}'
		};
	</script>

	{{ assets.outputJs("footer_scripts") }}
	{{ assets.outputJs("external_scripts") }}

	<!-- Add controller specific scripts -->
	{% for collection_name, collection_object in assets.getCollections() %}
	{% if collection_name is controller_scripts %}
	{{ assets.outputJs(collection_name) }}
	{% break %}
	{% endif %}
	{% endfor %}
	<!-- END controller specific scripts -->
</body>
</html>