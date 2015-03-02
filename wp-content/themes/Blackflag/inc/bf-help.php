<?php 
/**
 * Black flag help page
**/ 

add_action('admin_menu', 'blackflag_theme_help');

function blackflag_theme_help() {
	add_theme_page('Black flag help', 'Black flag Help & Guide', 'read', 'blackflag_help','blackflag_help_page');
}

function blackflag_help_page(){ ?>
	<div class="container">
	
		<h3 class="center alt">&ldquo;Black Flag theme&rdquo; Documentation by &ldquo;StepFox&rdquo;</h3>
		
		<hr>
		
		<h1 class="center">&ldquo;Black Flag&rdquo;</h1>
		
		<div class="borderTop">
			<div class="span-6 colborder info prepend-1">
				<p class="prepend-top">
					<strong>
					Created: 25/09/2014<br>
					By: StepFox<br>
					Email: <a href="StepFoxHelp@gmail.com">StepFoxHelp@gmail.com</a>
					</strong>
				</p>
			</div><!-- end div .span-6 -->		
	
			<div class="span-12 last">
				<p class="prepend-top append-0">Thank you for purchasing my theme. If you have any questions that are beyond the scope of this help file, please feel free to email us on the following mail: StepFoxHelp@Gmail.com . Thanks so much!</p>
			</div>
		</div><!-- end div .borderTop -->
		
		<hr>
		
		<h2 id="toc" class="alt">Table of Contents</h2>
		<ol class="alpha">
			<li><a href="#disclaimer">Disclaimer</a></li>
			<li><a href="#installation">Installation</a></li>
			<li><a href="#xmldata">XML Data</a></li>
			<li><a href="#themeoptions">Theme Options</a></li>
			<li><a href="#widgetareas">Widgets and Widget Areas</a></li>
			<li><a href="#widgetdesc">Widget Descriptions</a></li>
			<li><a href="#images">Images</a></li>
			<li><a href="#Videos">Videos</a></li>
			<li><a href="#reviews">Reviews</a></li>
			<li><a href="#gallery">Gallery</a></li>		
			<li><a href="#cssFiles">CSS Files and Structure</a></li>
			<li><a href="#javascript">JavaScript</a></li>
		</ol>

		<hr>
		<h3 id="disclaimer"><strong>1) Disclaimer</strong> - <a href="#toc">top</a></h3>
<p>I do offer support for the theme and its core features and functionality. I cannot guarantee
that this theme will function with all third-party components and plugins. The Black Flag Theme is presented as is.</p>

		<hr>
		<h3 id="installation"><strong>2) Installation</strong> - <a href="#toc">top</a></h3>
			<ol>
				<li>Make sure that you have the latest version of Wordpress installed.</li>
				<li>Upload the Black Flag theme to Wordpress in one of two different ways<p>	- Extract the blackflagtheme.zip and upload the extracted folder to the /wp-content/themes/ directory on your server.</p><p>- Or go to Appearance > Themes and click on the Install Themes tab at the top. Then click Upload and select blackflagtheme.zip and click Install Now.</p></li>
				<li>After you upload the theme, activate it by going to Appearance > Themes and click Activate underneath the Black Flag screenshot.</li>
			</ol>
			<img src="<?php echo get_template_directory_uri(); ?>/images/help/installation.jpg"/>

		<hr>
		<h3 id="xmldata"><strong>3) XML DATA</strong> - <a href="#toc">top</a></h3>
		<p>The Black Flag theme comes with dummy content via an XML file. This file includes dummy posts, pages, menus, tags, categories, one dummy photo and five
		dummy ads. To install the XML data, go to Tools > Import, click on WordPress then select the observer.xml file located in the XML Data folder of your
		original zip file. Then click Upload file and import. Choose a user to assign the posts to and make sure you click the Download and import file
		attachments checkbox and then click submit.</p>
		
		<hr>
		<h3 id="themeoptions"><strong>4) Theme Options</strong> - <a href="#toc">top</a></h3>
		<p>Black Flag comes with a plethora of custom theme Options that allow you to play with the design and the layout without touching the code.
To edit the Theme Options, go to Appearance > Customize.</p>
			<ol>
				<li><strong>Site Title, Tagline and Footer Copyright Text</strong><p>- This is where you set your site title, the tagline or slogan and the copyright text in the footer. Pretty much self explanatory.</p></li>
				<li><strong>Logo Options</strong>
<p>	- This is where you upload your logo and determine it's position, whether you want it on the left side of the header or in the center. Aditionaly you can upload a favicon and an apple touch icon for your site, and a smaller version of the logo that will appear on the floating menu. 
Logo should be 270x90 PNG image, while the favicon should be 16x16 PNG/GIF image. Apple touch icon should be 129x129 PNG/JPG. And the smaller version of the logo should be at least 100x36 PNG/JPG.</p></li>
				<li><strong>Theme Colors & Design</strong>
<p><strong>- Menu Background Color:</strong> This is where you change the color for the background of the menu.</p>
<p><strong>- Menu Border Color:</strong> Here you select the color for the menu border.</p>

<p><strong>- Menu Font Color:</strong> Selects the color of the font in the menu.</p>

<p><strong>- Primary Color:</strong> Here you can change the color of the hover effect, the links on the site, the color of the font on the slider and widget titles, etc.</p>

<p><strong>- Search Icon Color:</strong> This is where you select what color should the search icon in your search bar be. It can either be black or white.- Menu Font: Choose one from the handpicked fonts that work best with the overall design for your menu.</p>
<img src="<?php echo get_template_directory_uri(); ?>/images/help/1.jpg"/>
<p><strong>- Main Font:</strong> This is the font that is present throughout the site, everywhere except for the menu.</p>


<p><strong>- Menu Font:</strong> Here you can turn on or off the option for the following menu, when you scroll down the page.</p>

<p><strong>- Background Color:</strong> If you are not using an image for the background of the site, here you can determine the color of the background. </p>
</li>				
<img src="<?php echo get_template_directory_uri(); ?>/images/help/2.jpg"/>
				<li><strong>Ticker</strong>
<p>- Here you can find the options for the Ticker. You need to appoint a tag that you will use on the posts, that you want to appear on the ticker. Also 
you have the option to select how many posts should be visible on the ticker at one time. Or to hide the ticker altogether.</p></li>

				<li><strong>Post Page Options</strong>

<p>- Like the title suggests, here you have the options for the post page. You basically can decide whether to show/ or hide the social 
buttons, tags, comments and navigation links (next/prev post), but, also the widgets that are pre-placed by us in the sidebar, like the 'Related Posts' widget. Additionaly here you can select the font size of the text on the post page, and decide how big the media(image,video,gallery) you are displaying on the post page is. It can be 2/3 of the size of the page, or full width.
</p></li>

				<li><strong>Category & TV Page Options</strong>

<p>- Here you can decide how your Category page and your TV page will look like. For the category page you have the options to show the popular posts from that category at the bottom, or not. If so, you can decide how far back should the widget take into account when calculating the most popular posts. Additionaly you can decide how many posts should be visible on the category page. As for the TV page, you have the options to choose what type of widget will be displaying the latest videos on the TV page. You can choose between 3 different designs.
</p></li>

				<li><strong>Translate</strong>

<p>- If your website's language is not English, this is where you set up the translation. There are a few words throughout the site like 
read more, search, share, etc.. that you might want to translate to your language.

</p></li>

				<li><strong>Social Settings</strong>

<p>- This is where you fill in your social accounts. Just type your username/handle under the appropriate social media platform, and the 
rest will take care of itself.

</p></li>
	
					<li><strong>Ads & Tracking</strong>

<p>- This helps you set up ads and keep track of statistics. Simply copy and paste the code from the ad to the appropriate field or paste 
the google analytics(or any other) code in the tracking field. The ad will automaticly appear in the live preview.
</p></li>

					<li><strong>Background Image</strong>

<p>- If you don't want a solid color for a background, you can upload an image. Be it a nice landscape, a cool city skyline or a 
subtle pattern, here is where you do it.
</p></li>


					<li><strong>Navigation</strong>

<p>- Black Flag has spaces for three menus. Here you choose where to display the menus you have created. See the 
screenshot below for reference. Select which menu appears in each location. You can edit your menu content on the Menus screen 
in the Appearance section. For more information on how to use the Wordpress custom menu feature, <a href="http://codex.wordpress.org/Appearance_Menus_Screen">click here</a>. 
(http://codex.wordpress.org/Appearance_Menus_Screen)
</p></li>
<img src="<?php echo get_template_directory_uri(); ?>/images/help/3.jpg"/>
			
			</ol>

	<hr>
		<h3 id="widgetareas"><strong>5) Widgets and Widget Areas</strong> - <a href="#toc">top</a></h3>
	<p>Black Flag comes packed with 17 custom widgets you can use to build your site. Almost all widgets have 3 variations as to how they should appear. Each widget can assume three different forms. It can be only 1/3 wide, 2/3s or full width. What this basically means is that you can experiment with the layout of your site, and come up with almost unlimited number of combinations. In a way, building the Black Flag theme layout is a lot like playing Tetris, or assembling Lego pieces.</p>
<p>
<img src="<?php echo get_template_directory_uri(); ?>/images/help/6.jpg"/>
To set up your homepage, go to Appearance>Customize and at the very bottom of the menu you will see the Widgets: Homepage dropdown. Click on it and then on 'Add a Widget' button. Another menu should appear displaying the widgets, just select one and click on it, and the widget will be added to the homepage. It will appear right away in the preview window. Go ahead add another one, and this is basically how you build your homepage from the top down.</p>
<img src="<?php echo get_template_directory_uri(); ?>/images/help/5.jpg"/>
<p>
Similarly (if you already have posts and categories assigned in the theme), when you click on one of your posts, or categories while in the live preview, when the page loads, you will see that the Widget:Homepage option at the bottom of the menu is gone and replaced by Widgets: Post Sidebar or Widgets: Categroy Sidebar, depending on what you have clicked. This is where you can place widgets in the sidebars of the Post page or Category page. To do so the Category page should have at least 1/3 of the page available to place widgets in. This means that the category page post size should be Style 1, or Style 2.
</p>



<hr>
		<h3 id="widgetdesc"><strong>6) Widget Descriptions</strong> - <a href="#toc">top</a></h3>
	<p>Like we mentioned before, you can place almost any widget anywhere. Feel free experimenting with your layout,
or use one of the suggested layouts we have already made.
</p>

			<ol>
<li><b>Slider</b><p>- This is the slider widget. It displays posts based on 'tags'. It has three sizes, 1/3 of the page , 2/3 of the page, or full width. You can also select if the control thumbs are visible on the slider, or rather use the arrows as a navigation.</p></li>

<li><b>Jumping Posts</b><p>This is that neat looking widget whose posts jump up and change color when you hover over them. You can assign a category to this widget, or set it as 'All Categories', which basically means that the widget will display your latest posts. This widget also has three different forms, 1/3 wide, 2/3 wide and full width.</p></li>


<li><b>Carousel</b><p>
	This widget displays posts from a tag of your choice. Enter a title for this widget and select the tags you would like to use.
You can also select "All Tags" to display your latest posts. There is also an option that lets you choose how many posts 
you would like to display. This widget also has three different forms, 1/3 wide, 2/3 wide and full width.</p></li>

<li><b>Blogroll 1</b><p>
	- A widget, that displays your posts in a blog roll style. You can select how many posts you want to be displayed 
and of course, what category should they be. Also you can choose to hide/show the author of those posts, and add an alternative look to the 2/3 form of the widget. This alternative look makes the posts look in a classical blog style. This widget also has three different forms. It can be 1 column of posts(1/3), two columns(2/3), and three columns(full width).</p></li>

<li><b>Blogroll 2</b><p>
	- Another widget that displays your posts in a alternative blog roll style. You can select how many posts you want to be displayed 
and of course, what category should they be. Also you can choose to hide/show the author of those posts. This widget also has three different forms.
</p></li>

<li><b>Observer Featured Category</b><p>
	- A widget that displays posts from a category of your choice. Enter a title for this widget and select the category you would like to use.
	The latest post of that category will be displayed with a bigger image and a little text excerpt from the post. You can also select "All Categories"
	to display all posts on your site. This widget can also be placed in the sidebar.</p></li>

<li><b>Small Featured Images</b><p>
	- This widget displays posts with small images. What's different about it is  that you can display your review posts here, but also 
you can select a category, not just reviews. If you want to display reviews, tick the show reviews only box. There is also an option that lets you choose how many posts 
should be visible. This widget also has three different forms.</p></li>

<li><b>Big Featured Images</b><p>
	- This widget displays posts with bigger images. It also can display your review posts or select a category. If you want to display reviews, tick the show reviews only box. There is also an option that lets you choose how many posts 
should be visible. This widget also has three different forms.
</p></li>

<li><b>Featured Categories</b><p>
	- This widgets lets you chosse up to 3 categories that will be displayed. The latest posts from each of those categories willbe visible with the image, and the others with titles as links. This widget also has three different forms, but depending on which one you select, thats how many categories will be visible. For example if you select the 2/3rds form, than only 2 categories will be visible.</p></li>
	
<li><b>Multiple Categories</b><p>
	- This widget displays a certain category of your choosing, or if you tick the three category slider box, than you can select two additional categories. The latest post from the categories will
 have a bigger image, while the others will have smaller ones.This widget also has three different forms.
</p></li>
	
	<li><b>Tabs Widget</b><p>
	- This is a classical tabber widget, displaying the latest posts, the most popular ones and the latest comments from throughout 
the site. You have an option to change the title of each one of those, and select how many posts should be displayed. This widget has only one form (1/3).
 </p></li>
 
 
 	<li><b>TV Widget</b><p>
	- This widget automatically displayes the latest videos you have uploaded. When a visitor clicks on the video, he is taken to 
the video page directly. You can set how many of your latest videos should be visible on the widget. Visually very similar to the Multiple Categories widget.Also has 3 forms.

 </p></li>
 
 	<li><b>Most Commented</b><p>
	- A simple widget that displays the most commented posts on your site, along with the number of comments. This widget does not have three forms, only 1/3.

 </p></li>
 
  	<li><b>Thumbnails</b><p>
	- A widget that displays the latest posts from a category or the latest posts in general. The difference being that 
these posts are displayed with small thumbs. You can set how many of them should be visible. This widget has 3 forms, displaying the thumbnails in one column, two columns or three.
 </p></li>
 
   	<li><b>About Us
</b><p>
	- Like it's name suggests, this widgets lets you write something about yourself, so your visitors can get to know you better. It also displays your social media icons. This widget has only 1 form.
 </p></li>
 
    	<li><b>Author
</b><p>
	- This widget displays the author of the blog. You have the option to chosse what user is the author from the dropdown menu. An image and short bio, along with the social media icons will appear on the widget.
 </p></li>
 
     	<li><b>Ad Widget
</b><p>
	- This is where you place your adds. Just copy the Ad code in the appropriate field, and select what size is your advertisement.
 </p></li>
 
      	<li><b>Video
</b><p>
	- This widget displays a video that can be played directly on the homepage, or where ever you place it. Just add a link to the video, and select the size of the Video widget. It has the usual 3 form. 1/3, 2/3rds and full width.

 </p></li>
 
 
 

			</ol>

<hr>
		<h3 id="images"><strong>7) Images</strong> - <a href="#toc">top</a></h3>
	<p>Black Flag uses Wordpress' built-in featured image feature to handle image management. The recommended size for images to 
show properly on the site is 1008x515. However, if you don't use the Slider widget without control thumbs, and the featured media on the post page is not on full width, than you can use a
 smaller image, but no smaller than 843x499.

To set the featured image for a post, go to Posts > Add New (or edit an existing post) and click the set featured image in the featured 
image box. 
If the desired image is not already uploaded simply click on upload image and then select one and click set as featured image. Black Flag theme will take care of the rest in generating the smaller thumbnails that show up in the various widgets around the site.
<img src="<?php echo get_template_directory_uri(); ?>/images/help/7.jpg"/>
</p>

		<hr>

		<h3 id="Videos"><strong>8) Videos</strong> - <a href="#toc">top</a></h3>
	<p>Black Flag uses Wordpress' built-in featured video feature for easy video management. When creating a post, select video under 
Format options and then simply copy the video link and paste it in the Featured Video area. The theme will take care of the rest and your video will automatically appear on the video page as well. The video page is basically a page containing all the videos in your articles 
so far, in a nice layout which makes it easier to browse them and also more enjoyable to watch.
<img src="<?php echo get_template_directory_uri(); ?>/images/help/8.jpg"/>
</p>

		<hr>
		
		<h3 id="reviews"><strong>9) Reviews</strong> - <a href="#toc">top</a></h3>
	<p>It's really easy to set up a review post. Just like the video post, all you need to do is, select review from the format options on your post 
page. Once you do that, new options will appear under the text area. Here you can upload the image and give the name of the subject 
you are reviewing, and add a few short pros and cons to it (good and bad). Also here you add how many parameters the subject will be 
reviewed on, and what numbers it scores on each on it. The total amount of the scores will be summed up and shown over the image.
<img src="<?php echo get_template_directory_uri(); ?>/images/help/9.jpg"/>
</p>
		<hr>

		<h3 id="gallery"><strong>10) Gallery</strong> - <a href="#toc">top</a></h3>
	<p>It's really easy to set up a review post. Just like the video post, all you need to do is, select review from the format options on your post 
page. Once you do that, new options will appear under the text area. Here you can upload the image and give the name of the subject 
you are reviewing, and add a few short pros and cons to it (good and bad). Also here you add how many parameters the subject will be 
reviewed on, and what numbers it scores on each on it. The total amount of the scores will be summed up and shown over the image.
<img src="<?php echo get_template_directory_uri(); ?>/images/help/10.jpg"/>
</p>
		<hr>

		<h3 id="cssFiles"><strong>11) CSS Files and Structure</strong> - <a href="#toc">top</a></h3><ul>
		<li>
		<strong>style.css</strong> - Main theme stylesheet 
		</li>
		
		<li>
		<strong>/inc/bf-editor-style.css</strong> - Editor theme stylesheet 
		</li>
		
		<li>
		<strong>/inc/bf-post-style.css</strong> - Post stylesheet 
		</li>

		</ul>

		<hr>
		
		<h3 id="javascript"><strong>12) JavaScript</strong> - <a href="#toc">top</a></h3>
		
		<p>This theme imports three Javascript files.</p>
			<ul>
				<li><strong>/js/bf-post.js</strong> - Post scripts</li>
				<li><strong>/js/bf-scripts.js</strong> - Site scripts</li>
				<li><strong>/js/jquery.flexslider-min.js & jquery.flexslider.js</strong> - Flex Slider</li>
			</ul>

		<hr>
		
		<p>Once again, thank you so much for purchasing this theme. As I said at the beginning, we'd be glad to help you if you have any questions 
relating to this theme.</p> 
		
		<p class="append-bottom alt large"><strong>StepFox</strong></p>
		<p><a href="#toc">Go To Table of Contents</a></p>
		
		<hr class="space">
	</div><!-- end div .container -->
<?php } ?>