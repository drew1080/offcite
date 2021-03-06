<div id="right"> <img src="http://offcite.org/wp-content/uploads/2014/02/93-cover-thumb.jpg">

	<div id="description">
		<p><strong>Cite Magazine</strong>, the architecture and design review of Houston, has been published quarterly<br />
			by the <strong>Rice Design Alliance</strong><br />
			since 1982.</p>
		<h3>Current Issue: Cite 93</h3>
		<ul>
			<li><a href="http://citemag.org/" title="go to Cite Magazine">go to <strong>Cite Magazine</strong> &gt;</a></li>
			<li><a href="https://securews.rice.edu/rda.rice.edu/cite/index.cfm" title="subscribe to Cite Magazine">subscribe to <strong>Cite Magazine</strong> &gt;</a></li>
			<li><a href="http://citemag.org/advertise/" title="advertise in Cite Magazine">advertise in <strong>Cite Magazine</strong> &gt;</a></li>
		</ul>
	</div>
</div>
<div id="left">
	<form method="get" id="l_searchform" action="http://offcite.org/">
		<p>
			<input type="text" name="s" id="l_s" />
			<input type="image" src="http://offcite.org/wp-content/themes/offcite/images/left_search.png" id="l_searchsubmit" value="Go" />
		</p>
	</form>
	<ul id="sidebar">
		<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Left Offcite Sidebar' ) ) : ?>
		<?php wp_list_categories( 'show_count=1&title_li=<h2>Categories</h2>' );?>
		<?php //Yearly Archives ?>
		<li id="archives">
			<h2>Archives</h2>
			<ul>
				<li><a href="http://offcite.org/2008/" title="2008">2008</a></li>
			</ul>
		</li>
		<?php //Tag Cloud 

		if ( function_exists( 'wp_tag_cloud' ) ) : ?>
		<li id="popular">
			<h2>Popular Topics</h2>
			<?php wp_tag_cloud( 'smallest=8&largest=12&format=list&orderby=count&order=DESC&exclude=21' ); ?>
		</li>
		<?php endif; ?>
		<?php //Recommended Posts Loop ?>
		<li id="recommended">
			<h2>Recommended Posts</h2>
			<?php

				$recommendedPosts = new WP_Query();

				$recommendedPosts->query( 'showposts=5&tag=recommended' ); ?>
			<ul class="dotted">
				<?php while ($recommendedPosts->have_posts()) : $recommendedPosts->the_post(); ?>
				<li>
					<h5>
						<?php

							$recommendedCategory = get_the_category();

							echo $recommendedCategory[0]->cat_name; ?>
					</h5>
					<p><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?>
						</a></p>
				</li>
				<?php endwhile; ?>
			</ul>
		</li>
		<?php //Noted

		wp_list_bookmarks( 'title_li=&category=27&limit=5' ); ?>
		<li id="goodreads">
			<h2>Good Reads</h2>
			<ul class="dottedreads">
				<li><a href="#" title="topic"><img src="http://offcite.org/wp-content/themes/offcite/images/left_reads_one.jpg" alt="Good Read One" height="96" width="71" /><span>Liaigre</span> by <em>Christian Liaigre</em></a></li>
				<li><a href="#" title="topic"><img src="http://offcite.org/wp-content/themes/offcite/images/left_reads_two.jpg" alt="Good Read Two" height="86" width="68" /><span>Book 2</span> by <em>John Wick</em></a></li>
				<li><a href="#" title="topic"><img src="http://offcite.org/wp-content/themes/offcite/images/left_reads_three.jpg" alt="Good Read Three" height="91" width="106" /><span>Case Study Houses</span> by <em>Jonathan Urbriste</em></a></li>
			</ul>
		</li>
		<?php endif; ?>
	</ul>
</div>
</div>
<script type="text/javascript" src="http://offcite.org/wp-content/themes/offcite/js/jquery.example.min.js"></script>
<script type="text/javascript" src="http://offcite.org/wp-content/themes/offcite/js/jquery.cycle.all"></script> 
<script type="text/javascript" src="http://offcite.org/wp-content/themes/offcite/js/scripts.js"></script>
<?php wp_footer(); ?>
</body>
</html>