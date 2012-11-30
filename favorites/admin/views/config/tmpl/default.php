<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('script', 'favorites.js', 'media/com_favorites/js/'); ?>
<?php $form = @$this->form; ?>
<?php $row = @$this->row; ?>

<form action="<?php echo JRoute::_( @$form['action'] )?>" method="post" name="adminForm" enctype="multipart/form-data">

		<div id='onBeforeDisplay_wrapper'>
			<?php 
				$dispatcher = JDispatcher::getInstance();
				$dispatcher->trigger( 'onBeforeDisplayConfigForm', array() );
			?>
		</div>                

		<table style="width: 100%;">
			<tbody>
                <tr>
					<td style="vertical-align: top; min-width: 70%;">

					<?php
					// display defaults
					$pane = '1';
					echo $this->sliders->startPane( "pane_$pane" );
					
					$legend = JText::_( "Favorites Settings" );
					echo $this->sliders->startPanel( JText::_( $legend ), 'sitemap' );
					?>
					
					<table class="adminlist">
                    <tbody>
                    	<tr>
                            <th style="width: 25%;">
                                <?php echo JText::_( 'Add Button Text' ); ?>
                            </th>
                            <td>
                                <input name="favorites_add_text" value="<?php echo $this->row->get('favorites_add_text', ''); ?>" type="text" size="75" />
                            </td>
                            
                       </tr>
                       <tr>
                            <th style="width: 25%;">
                                <?php echo JText::_( 'Remove Button Text' ); ?>
                            </th>
                            <td>
                                <input name="favorites_remove_text" value="<?php echo $this->row->get('favorites_remove_text', ''); ?>" type="text" size="75" />
                            </td>
                            
                       </tr>
                        <tr>
                            <th style="width: 25%;">
                                <?php echo JText::_( 'ADD Button Class' ); ?>
                            </th>
                            <td>
                                <input name="favorites_add_class" value="<?php echo $this->row->get('favorites_add_class', ''); ?>" type="text" size="75" />
                            </td>
                            
                       </tr>
                        <tr>
                            <th style="width: 25%;">
                                <?php echo JText::_( 'Remove Button Class' ); ?>
                            </th>
                            <td>
                                <input name="favorites_remove_class" value="<?php echo $this->row->get('favorites_remove_class', ''); ?>" type="text" size="75" />
                            </td>
                            
                       </tr>
                       <tr>
                            <th style="width: 25%;">
                                <?php echo JText::_( 'Allow User to Edit Favorites' ); ?>
                            </th>
                            <td>
                                <input name="favorites_can_edit" value="<?php echo $this->row->get('favorites_can_edit', ''); ?>" type="text" size="75" />
                            </td>
                            
                        </tr>
                    	
                    	
                    	
                    	
                        <tr>
                            <th style="width: 25%;">
                                <?php echo JText::_( 'Allow User to Edit Favorites' ); ?>
                            </th>
                            <td>
                                <input name="favorites_can_edit" value="<?php echo $this->row->get('favorites_can_edit', ''); ?>" type="text" size="75" />
                            </td>
                            
                        </tr>
                        
						
					</tbody>
					</table>
					
					<?php
                    echo $this->sliders->endPanel();
					
					$legend = JText::_( "Other Settings" );
					echo $this->sliders->startPanel( JText::_( $legend ), 'others' );
					?>
					
					<table class="adminlist">
					<tbody>
						<tr>
			            	<th style="width: 25%;">
								<?php echo JText::_( 'Show Dioscouri Link in Footer' ); ?>
							</th>
			                <td>
								<?php echo JHTML::_('select.booleanlist', 'show_linkback', 'class="inputbox"', $this->row->get('show_linkback', '1') ); ?>
			                </td>
						</tr>
					</tbody>
					</table>
					<?php
					echo $this->sliders->endPanel();
					
					$legend = JText::_( "Administrator ToolTips" );
					echo $this->sliders->startPanel( JText::_( $legend ), 'defaults' );
					?>
					
					<table class="adminlist">
					<tbody>
						<tr>
			            	<th style="width: 25%;">
								<?php echo JText::_( 'Hide Dashboard Note' ); ?>
							</th>
							<td>
		                        <?php echo JHTML::_('select.booleanlist', 'page_tooltip_dashboard_disabled', 'class="inputbox"', $this->row->get('page_tooltip_dashboard_disabled', '0') ); ?>
							</td>
						</tr>
						<tr>
			            	<th style="width: 25%;">
								<?php echo JText::_( 'Hide Configuration Note' ); ?>
							</th>
							<td>
		                        <?php echo JHTML::_('select.booleanlist', 'page_tooltip_config_disabled', 'class="inputbox"', $this->row->get('page_tooltip_config_disabled', '0') ); ?>
							</td>
						</tr>
						<tr>
			            	<th style="width: 25%;">
								<?php echo JText::_( 'Hide Tools Note' ); ?>
							</th>
							<td>
		                        <?php echo JHTML::_('select.booleanlist', 'page_tooltip_tools_disabled', 'class="inputbox"', $this->row->get('page_tooltip_tools_disabled', '0') ); ?>
							</td>
						</tr>
					</tbody>
					</table>
					<?php
						echo $this->sliders->endPanel();				
						// if there are plugins, display them accordingly
		                if ($this->items_sliders) 
		                {               	
	                		$tab=1;
							$pane=2;
							for ($i=0, $count=count($this->items_sliders); $i < $count; $i++) {
								if ($pane == 1) {
									// echo $this->sliders->startPane( "pane_$pane" );
								}
								$item = $this->items_sliders[$i];
								echo $this->sliders->startPanel( JText::_( $item->element ), $item->element );
								
								// load the plugin
									$import = JPluginHelper::importPlugin( strtolower( 'Favorites' ), $item->element );
								// fire plugin
									$dispatcher = JDispatcher::getInstance();
									$dispatcher->trigger( 'onDisplayConfigFormSliders', array( $item, $this->row ) );
									
								echo $this->sliders->endPanel();
								if ($i == $count-1) {
									// echo $this->sliders->endPane();
								}
							}
						}						
						echo $this->sliders->endPane();					
					?>
					</td>
					<td style="vertical-align: top; max-width: 30%;">
						
						<?php echo DSCGrid::pagetooltip( JRequest::getVar('view') ); ?>
						
						<div id='onDisplayRightColumn_wrapper'>
							<?php
								$dispatcher = JDispatcher::getInstance();
								$dispatcher->trigger( 'onDisplayConfigFormRightColumn', array() );
							?>
						</div>

					</td>
                </tr>
            </tbody>
		</table>

		<div id='onAfterDisplay_wrapper'>
			<?php 
				$dispatcher = JDispatcher::getInstance();
				$dispatcher->trigger( 'onAfterDisplayConfigForm', array() );
			?>
		</div>
        
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="" />
	<input type="hidden" name="filter_order" value="<?php echo @$state->order; ?>" />
	<input type="hidden" name="filter_direction" value="<?php echo @$state->direction; ?>" />
	
	<?php echo $this->form['validate']; ?>
</form>
