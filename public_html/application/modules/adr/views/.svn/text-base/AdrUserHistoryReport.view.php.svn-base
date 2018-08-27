<?php

class AdrUserHistoryReport extends Render {
	
	static public function render () {
	
		ob_start();
		
		?>
		<div>
			
			<div id="report-container-table">
			    <div id="report-content-row" class="report-head-content">
			        <div  class="head-column_1"><?=Util::getLiteral('zone_name')?></div>
		    	    <div  class="head-column_1"><?=Util::getLiteral('event_time_in')?></div>
			        <div  class="head-column_1"><?=Util::getLiteral('event_time_out')?></div>
					<div  class="head-column_1"><?=Util::getLiteral('time_in_zone')?></div>
			    </div>

			    <!-- Content auto append -->

			</div>

		</div>
		<?php

		return ob_get_clean();
	}

}
?>