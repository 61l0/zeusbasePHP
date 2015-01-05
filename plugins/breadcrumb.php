
		<?php			
			// Build Breadcrumbs
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb($this->config->item('site_title'), site_url()); 
			$this->breadcrumb->add_crumb($this->router->class, site_url($this->router->class)); 
			$this->breadcrumb->add_crumb($this->router->method);
		?>
		<ol class="breadcrumb">
			<?php echo ($this->breadcrumb->output()); ?>
		</ol>					
			
