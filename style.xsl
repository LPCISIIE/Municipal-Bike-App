<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"/>

<xsl:template match="/">
  <html>
    <head>
    
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
      <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
   	  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.13.0/css/semantic.min.css" />
	  <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
   	  <script src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.13.0/javascript/semantic.min.js"></script>
   	   <link rel="stylesheet" href="http://ehkoo.github.io/semantic-ui-examples/theme/main.css" />
   	     <link rel="stylesheet" href="style.css"/>
   
    </head>

    <body>
    	<nav class="ui fixed menu inverted navbar">
	        <a href="" class="brand item">BikeXML</a>
	        <a href="" class="active item">Home</a>
   		</nav> 

		<div class="ui five column relaxed grid"> 
  		    <xsl:apply-templates select="previsions/echeance[@hour='3']"/>
		    <xsl:apply-templates select="previsions/echeance[@hour='6']"/>
		    <xsl:apply-templates select="previsions/echeance[@hour='9']"/>
		    <xsl:apply-templates select="previsions/echeance[@hour='12']"/>
	        <xsl:apply-templates select="previsions/echeance[@hour='24']"/>
		</div>
   	  

	    <div id="mapid" style="height: 440px; border: 1px solid #AAA;"></div>


    </body>

 	

  </html>

</xsl:template>


<xsl:template match="echeance">


    <div class="column">
	
		      <i class='large cloud icon'></i> 
		  
		      <p> In <xsl:value-of select="@hour"/> hours <br/> <xsl:value-of select="format-number(temperature/level[@val='sol']-273.15,'#')"/> °C <br/></p>
		    
	</div>


</xsl:template>

</xsl:stylesheet>




