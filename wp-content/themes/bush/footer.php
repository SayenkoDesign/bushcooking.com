<div id="signup">
    <div class="row column">
        <h4 class="text-center">GET OUTDOOR COOKING RECIPIES & EXPERT TECHINQUES</h4>
        <form action="">
            <div class="input-group">
                <input class="input-group-field" type="email" placeholder="SIGN UP FOR OUR NEWSLETTER" />
                <div class="input-group-button">
                    <input type="submit" class="button" value="SIGN UP" />
                </div>
            </div>
        </form>
    </div>
</div>

<div id="footer-logo">
    <div class="expanded row column">
        <?php if(get_header_image()): ?>
            <a href="<?php get_home_url(); ?>">
                <img src="<?php echo get_header_image(); ?>" alt="">
            </a>
        <?php endif; ?>
    </div>
</div>

<div id="footer">
    <div class="row" id="footer-menus">
        <div class="medium-3 medium-push-2 columns">
            <h4>RECIPE CATEGORIES</h4>
            <ul class="no-bullet">
                <li><a href="#">Sample 1</a></li>
                <li><a href="#">Sample 2</a></li>
                <li><a href="#">Sample 3</a></li>
                <li><a href="#">Sample 4</a></li>
                <li><a href="#">Sample 5</a></li>
                <li><a href="#">Sample 6</a></li>
            </ul>
        </div>
        <div class="medium-2 medium-push-2 columns text-center">
            <ul class="menu">
                <li><a href="https://www.pinterest.com/Bush_Cooking/" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="https://www.facebook.com/BushCooking" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://twitter.com/BushCooking" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://plus.google.com/u/0/b/116280046121062819121/116280046121062819121" target="_blank"><i class="fa fa-google-plus"></i></a></li>
            </ul>
            <p><a href="#">Advertise with Us</a></p>
        </div>
        <div class="medium-3 medium-pull-2 columns">
            <h4>BLOG CATEGORIES</h4>
            <ul class="no-bullet">
                <li><a href="#">Sample 1</a></li>
                <li><a href="#">Sample 2</a></li>
                <li><a href="#">Sample 3</a></li>
                <li><a href="#">Sample 4</a></li>
                <li><a href="#">Sample 5</a></li>
                <li><a href="#">Sample 6</a></li>
            </ul>
        </div>
    </div>
    <div class="expanded row column text-center" id="footer-copyright">
        <p>
            &copy; 2015 Bush Cooking.  All rights reserved. <a href="" target="_blank">Seattle Web Design</a> by Sayenko Design.
            |
            <a href="#">Privacy Policy</a>
        </p>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>