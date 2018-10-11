<?php
class ClaimsNewMultiple extends Render {

	static public function render ($claim, $subjectsList, $inputTypeList, $causeList, $dependencyList, $stateList, $typeAddress = false) {
		
		ob_start();
	
		/* @var $claim Claim */
		$style = '';
		$disabledInputType = 'disabled="disabled"';
		$disabledEntryDate = 'disabled="disabled"';
		//Nuevo
		if($claim->getId() == null) {
			$style = 'style="display: none;"';
			$defaultState = claimsConcepts::PENDINGSTATE;
			$entryDate = date('d/m/Y');
			$origin = claimsConcepts::CLAIMTYPEMANUALID;
		//Existente
		} else {
			$entryDate = date('d/m/Y', strtotime(str_replace('/', '-', $claim->getEntryDateForDB())));
			$origin = $claim->getOriginId();
			$disabledInputType = '';
		}
		?>

		<script type="text/javascript">
		var geolocationEnabled = <?echo $typeAddress? 'false':'true'?>;
		</script>
<br>
		<div class="container" >
			<!-- Example row of columns id="claim-new-edit"-->
			<div class="row">
				<div class="col-md-4">

				</div>
				<div class="col-md-4"  >

					<form id="claimNewEditForm" name="claimNewEditForm" method="POST" action="" autocomplete="off">
						<div  <?=$style?>>
							<label><?=Util::getLiteral('claim_code')?>:</label><input type="text" id="code" class="form-control" name="code" value="<?=$claim->getCode()?>" disabled="disabled" />
						</div>
						<div >
							<div class="textbox">
								<label><?=Util::getLiteral('subject_name')?>:</label>
							</div>
							<div class="opt-box">
								<select id="subject" class="form-control mandatory-input" name="subjectId"  />
								<option value=""><?=Util::getLiteral('claim_subject_select_one')?></option>
								<?php
								/* @var $subject Subject */
								foreach ($subjectsList as $subject) {
									$selectedSubject = '';
									if($subject->getId() == $claim->getSubjectId()) {
										$selectedSubject = 'selected="selected"';
									}
									echo '<option value="'.$subject->getId().'" '.$selectedSubject.'>'.$subject->getName().'</option>';
								}
								?>
								</select>
							</div>
						</div>
						<div >
							<div class="textbox">
								<label><?=Util::getLiteral('input_type_name')?>:</label>
							</div>
							<div class="opt-box">
								<select id="input-type" class="form-control" name="inputTypeId" <?=$disabledInputType?> />
								<option value=""><?=Util::getLiteral('claim_inputtype_select_one')?></option>
								<?php
								/* @var $inputType InputType */
								$defaultInputType = claimsConcepts::CLAIMINPUTTYPEMANUALID;
								foreach ($inputTypeList as $inputType) {
									if($inputType->getId() == $claim->getInputTypeId()) {
										$defaultInputType =  $claim->getInputTypeId();
									}
									$selectedInputType = '';
									if($defaultInputType) {
										$selectedInputType = 'selected="selected"';
										$defaultInputType = '';
									}
									echo '<option value="'.$inputType->getId().'" '.$selectedInputType.'>'.$inputType->getName().'</option>';
								}
								?>
								</select>
							</div>
						</div>
						<div >
							<div class="textbox">
								<label><?=Util::getLiteral('cause_name')?>:</label>
							</div>
							<div class="opt-box">
								<select id="causeId" class="form-control mandatory-input" name="causeId" />
								<option value=""><?=Util::getLiteral('claim_cause_select_one')?></option>
								<?php
								/* @var $cause Cause */
								foreach ($causeList as $cause) {
									$selectedCause = '';
									if($cause->getId() == $claim->getCauseId()) {
										$selectedCause = 'selected="selected"';
									}
									echo '<option value="'.$cause->getId().'" '.$selectedCause.'>'.$cause->getName().'</option>';
								}
								?>
								</select>
							</div>
						</div>
						<div >
							<div class="textbox">
								<label><?=Util::getLiteral('dependency')?>:</label>
							</div>
							<div class="opt-box">
								<select id="dependencyId" class="form-control mandatory-input" name="dependencyId" />
								<option value=""><?=Util::getLiteral('claim_dependency_select_one')?></option>
								<?php
								/* @var $dependency Dependency */
								foreach ($dependencyList as $dependency) {
									$selectedDependency = '';
									if($dependency->getId() == $claim->getDependencyId()) {
										$selectedDependency = 'selected="selected"';
									}
									echo '<option value="'.$dependency->getId().'" '.$selectedDependency.'>'.$dependency->getName().'</option>';
								}
								?>
								</select>
							</div>
						</div>
						<div >
							<div class="textbox">
								<label><?=Util::getLiteral('state')?>:</label>
							</div>
							<div class="opt-box">
								<select id="stateId" class="form-control mandatory-input" name="stateId" disabled="disabled" />
								<option value=""><?=Util::getLiteral('claim_state_select_one')?></option>
								<?php
								/* @var $state State */
								foreach ($stateList as $state) {
									$selectedState = '';
									if($state->getId() == $claim->getStateId()) {
										$defaultState = $claim->getStateId();
									}
									if($defaultState) {
										$selectedState = 'selected="selected"';
										$defaultState = '';
									}
									echo '<option value="'.$state->getId().'" '.$selectedState.'>'.$state->getName().'</option>';
								}
								?>
								</select>
							</div>
						</div>
						<div >
							<div class="textbox">
								<label><?=Util::getLiteral('entry_date')?>:</label>
								<input type="hidden" id="default-date" value="<?=$entryDate?>" />
								<div class="lineal-box">
									<input maxlength="50"
										   class="datepicker"
										   type="text"
										   name="entryDate"
										   id="entry-date"
										   readonly="readonly"
										<?=$disabledEntryDate?> />
								</div>
							</div>
						</div>
						<div class="claim-form-item">
							<?
							$closedDate = $claim->getClosedDate();
							if(!$closedDate){
								$closedDate = '';

							} else{
								$closedDate = $closedDate->format('d/m/Y');
							}
							?>
							<div class="textbox">
								<label><?=Util::getLiteral('claim_closed_date')?>:</label>
								<div class="lineal-box1">
									<input type="text" id="closed-date" class="datepicker" name="" value="<?=$closedDate ?>" disabled="disabled" />
								</div>
							</div>
						</div>
						<div class="claim-form-item">
							<div class="textbox">
								<label><?=Util::getLiteral('requester_name')?>:</label>
								<div class="lineal-box2">
									<input type="text" id="requester-name" class="form-control mandatory-input" name="requesterName" value="<?=$claim->getRequesterName()?>" />
								</div>
							</div>
						</div>
						<div class="claim-form-item">
							<div class="textbox">
								<label><?=Util::getLiteral('requester_phone')?>:</label>
								<div class="lineal-box2">
									<input type="text" id="requester-phone" class="form-control mandatory-input" name="requesterPhone" value="<?=$claim->getRequesterPhone()?>" />
								</div>
							</div>
						</div>

						<!----------------------------- -->

						<?php
						if($typeAddress){
							$selectedStreetNumber = "";
							$selecteddbh = "";
							$default = "";
							$typeAddressConcept = "";
							if($claim->getTypeAddress() != null){
								$typeAddressConcept = $claim->getTypeAddress()->getType();
							}
							$streetValue = "";
							$numberValue = "";
							$districtValue = "";
							$blockValue = "";
							$houseValue = "";

							switch ($typeAddressConcept){
								case claimsConcepts::CLAIM_STREET_NUMBER:
									$selectedStreetNumber = 'selected="selected"';
									if($claim->getTypeAddress() != null){
										$streetValue = $claim->getTypeAddress()->getStreet();
										$numberValue = $claim->getTypeAddress()->getNumber();

									}
									break;
								case claimsConcepts::CLAIM_DISTRICT_BLOCK_HOUSE:
									$selecteddbh =  'selected="selected"';
									if($claim->getTypeAddress() != null){
										$districtValue = $claim->getTypeAddress()->getDistrict();
										$blockValue = $claim->getTypeAddress()->getBlock();
										$houseValue = $claim->getTypeAddress()->getHouse();
									}
									break;
								default:
									$default =  'selected="selected"';
							}
							?>

						
							<div class="claim-form-item" id="claim_address" style="display: none;">
								<!-- <label style="float: left; padding-right:2%;">:</label> -->
								<!-- <input type="text" id="claim-address" class="form-control" name="claimAddress" value="<?=$claim->getClaimAddress()?>" style="float: left;"/> -->
								<div onclick="geoPositionMapMultiplePoints(<?=$claim->getId()?>);" title="<?=Util::getLiteral('claim_geolocator')?>" class="close_icon geo_button" style="float: left;"></div>
							</div>

							<?php

						}else{

							?>
							<div class="claim-form-item" id="claim_address"  >
								<!-- <label style="float: left; padding-right:2%;">:</label> -->
								<!-- <input type="text" id="claim-address" class="form-control" name="claimAddress" value="<?=$claim->getClaimAddress()?>" style="float: left;"/> -->
								<div onclick="geoPositionMapMultiplePoints(<?=$claim->getId()?>);" title="<?=Util::getLiteral('claim_geolocator')?>" class="close_icon geo_button" style="float: left;"></div>
							</div>

							<?php
						}
						?>

						<div class="claim-form-item">
							<div class="textbox">
								<label>points:</label>
								<div class="lineal-box2">
									<input type="hidden" id="markers" class="form-control" name="markers" readonly="readonly"/>
								</div>
							</div>
						</div>
						<!-- <div class="claim-form-item">
							<div class="textbox">
								<label>:</label>
								<div class="lineal-box2">
									<input type="text" id="latitude" class="form-control" name="latitude" readonly="readonly"   value="<?=$claim->getLatitude()?>" />
								</div>
							</div>
						</div>
						<div class="claim-form-item">
							<div class="textbox">
								<label>:</label>
								<div class="lineal-box2">
									<input type="text" id="longitude" class="form-control" name="longitude" readonly="readonly"  value="<?=$claim->getLongitude()?>" />
								</div>
							</div>
						</div> -->
						<div class="claim-form-item">
							<div class="textbox">
								<label><?=Util::getLiteral('claim_neighborhood')?>:</label>
								<div class="lineal-box2">
									<input type="text" id="neighborhood" class="form-control" name="neighborhood" value="<?=$claim->getNeighborhood()?>" />
								</div>
							</div>
						</div>
						<div class="claim-form-item">
							<div class="textbox">
								<label><?=Util::getLiteral('claim_piquete')?>:</label>
								<div class="lineal-box2">
									<input type="text" id="piquete" class="form-control" name="piquete" value="<?=$claim->getPiquete()?>" />
								</div>
							</div>
						</div>
						<div class="claim-form-item">
							<div class="textbox">
								<label><?=Util::getLiteral('claim_detail')?>:</label>
								<div class="lineal-box2">
									<input type="text" id="detail" class="form-control" name="detail" value="<?=$claim->getDetail()?>" />
								</div>
							</div>
						</div>
						<!--<div class="claim-form-item">
                        <label for="imagen">Imagen:</label>
                        <input type="file" name="imagen" id="imagen" />
                            </div>-->
						<div class="claim-form-item" style="border-top: 1px solid #a9bdc6;">
							<input type="hidden" name="originId" id="origin-id" value="<?=$origin?>" />
							<input type="hidden" name="id" id="id" value="<?=$claim->getId()?>" />


							<div onclick="saveClaims();" title="<?=Util::getLiteral('claim_save')?>" class="btn btn-success action_button"><?=Util::getLiteral('claim_save')?></div>


							<div onclick="cancelSaveClaim();" title="<?=Util::getLiteral('claim_cancel_save')?>" class="btn btn-danger action_button"><?=Util::getLiteral('claim_cancel_save')?></div>
						</div>
					</form>
				</div>

				<div class="col-md-4">

				</div>

			</div>


		<?php
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
    	$_REQUEST['jsToLoad'][] = "/modules/claims/js/claims.js";
				
		return ob_get_clean();
	}
	
}
?>