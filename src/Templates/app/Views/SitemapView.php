<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
	foreach($sitemap as $r){
		?>
	<url>
        <loc><?= $r; ?></loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>
	<?php
	}
	?>
</urlset>