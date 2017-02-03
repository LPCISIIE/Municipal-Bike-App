<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html"/>
	<xsl:template match="/">
	  <html>
		<head>
			<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
			<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
			<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.css" />
			<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
			<script src="//cdn.jsdelivr.net/semantic-ui/2.2.6/semantic.min.js"></script>
			<link rel="stylesheet" href="http://ehkoo.github.io/semantic-ui-examples/theme/main.css" />
			<link rel="stylesheet" href="style.css"/>
		</head>
		<body>
			<nav class="ui fixed menu inverted navbar">
				<a href="" class="brand item">BikeXML</a>
				<a href="" class="active item">Home</a>
			</nav>

			<div class="ui weather">
				<h2>WEATHER</h2>
				<div class="ui center aligned five column grid ">
					<xsl:apply-templates select="application/weather/day[@hour='3']"/>
					<xsl:apply-templates select="application/weather/day[@hour='6']"/>
					<xsl:apply-templates select="application/weather/day[@hour='9']"/>
					<xsl:apply-templates select="application/weather/day[@hour='12']"/>
					<xsl:apply-templates select="application/weather/day[@hour='24']"/>
				</div>
			</div>

			<div id="mapid" style="height: 80%; border: 1px solid #AAA;"></div>

			<script>
				var bike = '<i class="marker icon"></i>'
				var mymap = L.map('mapid').setView([<xsl:value-of select="application/user/@latitude"/>, <xsl:value-of select="application/user/@longitude"/>], 13);
				L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoieGNob3BpbiIsImEiOiJjaXluMXg0cTAwMDBwM3VwZnN0Y2ZxM3JmIn0.Hfr7AY-5aNpongUyCXdOUg', {
						     maxZoom: 18 ,attribution: 'Xavier CHOPIN and Alexis WURTH © <a href="http://univ-lorraine.fr">University of Lorraine</a>',id: 'mapbox.streets'
				}).addTo(mymap)
			    <xsl:apply-templates select="application/velostan"/>
			</script>
		</body>
	  </html>
	</xsl:template>


	<xsl:template match="day">
		<div class="column">
			<p>
				In <xsl:value-of select="@hour"/> hours <br/>  <br/>
				<i class='large cloud icon'></i> <xsl:value-of select="format-number(temperature[@val='sol']-273.15,'#')"/> °C <br/>
			</p>
        </div>
	</xsl:template>

	<xsl:template match="marker">

		L.marker([<xsl:value-of select="@lat"/>, <xsl:value-of select="@lng"/>]).addTo(mymap).bindPopup("<b>"+ bike +"<xsl:value-of select="@address"/></b><br/> This place can host <xsl:value-of select="station/@total"/> bikes  <br/> <xsl:value-of select="station/@available"/> bikes are available <br/> <xsl:value-of select="station/@free"/> parking places are available .");
	</xsl:template>




</xsl:stylesheet>