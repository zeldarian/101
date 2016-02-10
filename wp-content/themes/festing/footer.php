	</div> <!-- .row on head -->
	</div> <!-- .container on head -->
	</div> <!-- .ktz-inner-content head -->
	<footer class="footer">
	
	<div class="container">
	<?php //hook_ktz_footerbanner(); ?>
	</div>
	
	<?php if ( is_active_sidebar('widget_fot1') ): ?>
	<div class="wrapfootwidget">
		<div class="container">
			<?php hook_ktz_footer(); ?>
		</div>
	</div>
	<?php endif; ?>
	<div class="copyright">
	<nav class="ktz-footermenu">
		<div class="container">
			<?php hook_ktz_menu_footer(); //Kentooz_hook_system ?>
		</div>	
	</nav>
		<div class="container">
				<?php hook_ktz_after_footer(); ?>
				<?php hook_do_ktz_header_sn(); ?>
		</div>
	</div>
	</footer>
	</div> <!-- .all-wrapper on head -->
	<div id="ktz-backtotop"><a href="#"><span class="fontawesome ktzfo-double-angle-up"></span><br />Top</a></div>
	<?php wp_footer();echo ot_get_option("ktz_footer")  . "\n"; ?>
</body>
</html>